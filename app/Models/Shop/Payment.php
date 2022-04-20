<?php

namespace App\Models\Shop;

use App\Events\Order\OrderValidated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed|string type
 * @property int|mixed amount
 * @property mixed currency
 * @property mixed|string reference
 * @property mixed|string status
 * @property Carbon created_at
 * @property mixed order_id
 * @property false|mixed|string trans_id
 * @property Order order
 * @property mixed trans_uuid
 * @method static where(string $string, string $string1, string $string2)
 */
class Payment extends Model
{
    use HasFactory;

    const DATE_FORMAT = 'y';
    const STR_PAD_LENGTH = 5;
    const STR_TRANS_ID_LENGTH = 6;
    const STR_PAD_STRING = '0';

    const TYPE_CREDIT = 'credit';
    const TYPE_STRIPE = 'stripe';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_BANK_CARD = 'bank-card';
    const TYPE_BANK_TRANSFER = 'bank-transfer';
    const TYPE_CASH = 'cash';

    const STATUS_PING = 'ping';
    const STATUS_AUTHORIZED = 'authorized';
    const STATUS_CAPTURED = 'captured';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUSED = 'refused';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_COMPLETE = 'complete';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->user_id && auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                $model->user_id = $user->getKey();
            }

            if (!$model->reference) {
                $model->generateReference();
            }

            if (!$model->trans_id) {
                $model->generateTransId();
            }
        });
    }

    /**
     * Generate payment reference
     */
    public function generateTransId()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVW0123456789";

        do{
            $transId = substr(str_shuffle($chars), 0, self::STR_TRANS_ID_LENGTH);
            $exists = Payment::where('payments.trans_id', '=', $transId)
                ->exists();
        }while($exists);

        $this->trans_id = $transId;
    }

    /**
     * Generate payment reference
     */
    public function generateReference()
    {
        $date = date(Payment::DATE_FORMAT);
        switch (true){
            case $this->type === Payment::TYPE_BANK_CARD:
                $prefix = "PBC$date";
                break;
            case $this->type === Payment::TYPE_BANK_TRANSFER:
                $prefix = "PBT$date";
                break;
            case $this->type === Payment::TYPE_CREDIT:
                $prefix = "PCR$date";
            break;
            case $this->type === Payment::TYPE_CASH:
                $prefix = "PCS$date";
            break;
            default:
                $prefix = "PDF$date";
            break;
        }

        $payment = Payment::where('payments.reference', 'LIKE', "$prefix %")
            ->orderBy('payments.reference', 'desc')
            ->first();

        if($payment){
            $id = explode(' ', $payment->reference);
            $id = $id[1] ?? 0;
        }else{
            $id = 0;
        }

        do{
            $id++;
            $reference = str_pad($id, Payment::STR_PAD_LENGTH, Payment::STR_PAD_STRING, STR_PAD_LEFT);
            $exists = Payment::where('payments.reference', '=', "$prefix-$reference")
                ->exists();
        }while($exists);

        $this->reference = "$prefix-$reference";
    }

    /**
     * Get the order that owns the payment.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that owns the payment.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Complete an payment
     *
     * @return Payment
     */
    public function complete(): Payment
    {
        $this->status = self::STATUS_COMPLETE;
        $this->save();

        return $this;
    }
}
