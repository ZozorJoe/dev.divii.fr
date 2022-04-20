<?php

namespace App\Models\Shop;

use App\Events\Order\Checkout;
use App\Events\Order\OrderCanceled;
use App\Events\Order\OrderComplete;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderRefused;
use App\Events\Order\OrderValidated;
use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use App\Models\Chat\Room;
use App\Models\Sale\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string status
 * @property User user
 * @property string payment_type
 * @property string payment_status
 * @property mixed $sub_total
 * @property int|mixed $vat_total
 * @property int|mixed $total
 * @property mixed $currency
 * @property OrderItem[] items
 * @property mixed user_id
 * @property float|int|mixed discount_total
 * @property mixed coupon_id
 * @property Coupon coupon
 * @property mixed created_at
 * @method static find(mixed $cartId)
 */
class Order extends Model
{
    use HasFactory;

    const STATUS_PING = 'ping';
    const STATUS_PROCESSING = 'processing';
    const STATUS_VALIDATED = 'validated';
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUSED = 'refused';

    const PAYMENT_TYPE_CREDIT = 'credit';
    const PAYMENT_TYPE_STRIPE = 'stripe';
    const PAYMENT_TYPE_PAYPAL = 'paypal';
    const PAYMENT_TYPE_BANK_CARD = 'bank-card';
    const PAYMENT_TYPE_BANK_TRANSFER = 'bank-transfer';
    const PAYMENT_TYPE_CASH = 'cash';
    const PAYMENT_TYPE_VOUCHER = 'voucher';
    const PAYMENT_TYPE_FREE = 'free';

    const PAYMENT_STATUS_PING = 'ping';
    const PAYMENT_STATUS_AUTHORIZED = 'authorized';
    const PAYMENT_STATUS_CAPTURED = 'captured';
    const PAYMENT_STATUS_CANCELED = 'canceled';
    const PAYMENT_STATUS_REFUSED = 'refused';
    const PAYMENT_STATUS_REFUNDED = 'refunded';
    const PAYMENT_STATUS_COMPLETE = 'complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'status',
        'sub_total',
        'vat_total',
        'total',
        'currency',
        'user_id',
        'payment_type',
        'payment_status',
    ];

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
        });

        static::saving(function ($model) {
            $sub_total = $vat_total = $total = 0;
            $items = $model->items()->get();
            foreach ($items as $item){
                $sub_total += $item->sub_total;
                $vat_total += $item->vat_total;
                $total += $item->row_total;
            }
            $model->sub_total = $sub_total;
            $model->vat_total = $vat_total;
            $model->total = $total;

            $coupon = $model->coupon;
            if($coupon){
                $model->discount_total = $coupon->getDiscount($sub_total);
                $model->total -= $model->discount_total;
            }
        });
    }

    /**
     * @param $id
     * @param int $quantity
     * @return bool
     */
    public function addConsultation($id, int $quantity = 1): bool
    {
        /** @var Consultation $consultation */
        $consultation = Consultation::where('id', '=', $id)->first();
        if($consultation){
            /** @var OrderItem $item */
            $item = $this->items()
                ->where('orderable_id', $id)
                ->where('orderable_type', Consultation::class)
                ->first();
            if(!$item) {
                $item = new OrderItem();
                $item->orderable()->associate($consultation);
                $item->currency = $this->currency;
                $item->vat = $consultation->duration->vat;
                $item->price = $consultation->duration->price;
            }
            $item->addQuantity($quantity);

            $this->items()->save($item);

            return $this->save();
        }
        return false;
    }

    /**
     * @param $id
     * @param int $quantity
     * @return bool
     */
    public function addFormation($id, int $quantity = 1): bool
    {
        /** @var Formation $formation */
        $formation = Formation::where('id', '=', $id)->first();
        if($formation){
            /** @var OrderItem $item */
            $item = $this->items()
                ->where('orderable_id', $id)
                ->where('orderable_type', Formation::class)
                ->first();
            if(!$item) {
                $item = new OrderItem();
                $item->orderable()->associate($formation);
                $item->currency = $this->currency;
                $item->vat = $formation->vat;
                $item->price = $formation->price;
            }
            $item->addQuantity($quantity);

            $this->items()->save($item);

            return $this->save();
        }
        return false;
    }

    /**
     * @param $id
     * @param int $quantity
     * @return bool
     */
    public function addProduct($id, int $quantity = 1): bool
    {
        /** @var Product $product */
        $product = Product::where('id', '=', $id)->first();
        if($product){
            /** @var OrderItem $item */
            $item = $this->items()
                ->where('orderable_id', $id)
                ->where('orderable_type', Product::class)
                ->first();
            if(!$item) {
                $item = new OrderItem();
                $item->orderable()->associate($product);
                $item->currency = $this->currency;
                $item->vat = $product->vat;
                $item->price = $product->price;
            }
            $item->addQuantity($quantity);

            $this->items()->save($item);

            return $this->save();
        }
        return false;
    }

    /**
     * Cancel an order
     *
     * @return Order
     */
    public function cancel(): Order
    {
        $this->status = self::STATUS_CANCELED;
        $this->save();

        event(new OrderCanceled($this));

        return $this;
    }

    /**
     * Init checkout
     *
     * @param string $paymentType
     * @return Payment
     */
    public function checkout(string $paymentType): Payment
    {
        $payment = new Payment();
        $payment->type = $paymentType;
        $payment->status = Payment::STATUS_PING;
        $payment->amount = $this->total;
        $payment->currency = $this->currency;
        $this->payments()->save($payment);

        $this->payment_type = $payment->type;
        $this->payment_status = $payment->status;
        $this->status = Order::STATUS_PROCESSING;
        $this->save();

        event(new Checkout($this, $payment));

        return $payment;
    }

    /**
     * Complete an order
     *
     * @return Order
     */
    public function complete(): Order
    {
        $this->status = self::STATUS_COMPLETE;
        $this->save();

        event(new OrderComplete($this));

        return $this;
    }

    /**
     * Get the coupon that owns the order.
     *
     * @return BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the items for the order.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payments for the order.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Refuse an order
     *
     * @return Order
     */
    public function refuse(): Order
    {
        $this->status = self::STATUS_REFUSED;
        $this->save();

        event(new OrderRefused($this));

        return $this;
    }

    /**
     * Get the rooms for the order.
     *
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the user that owns the order.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Validate an order
     *
     * @return Order
     */
    public function validate(): Order
    {
        $this->status = self::STATUS_VALIDATED;
        $this->save();

        event(new OrderValidated($this));

        return $this;
    }

    /**
     * Validate an order
     *
     * @return Order
     */
    public function pay(): Order
    {
        $this->payment_status = self::PAYMENT_STATUS_COMPLETE;
        $this->save();

        event(new OrderPaid($this));

        return $this;
    }

    public function applyCoupon(Coupon $coupon)
    {
        $this->coupon_id = $coupon->getKey();
        $this->save();
    }
}
