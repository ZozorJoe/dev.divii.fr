<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed user_id
 * @property mixed order_id
 * @property int|mixed sub_total
 * @property int|mixed vat_total
 * @property int|mixed total
 * @property mixed currency
 * @property mixed reference
 * @property mixed|string type
 * @property mixed|string status
 * @method static where(string $string, string $string1, string $string2)
 */
class Invoice extends Model
{
    use HasFactory;

    const DATE_FORMAT = 'y';
    const STR_PAD_LENGTH = 5;
    const STR_PAD_STRING = '0';
    const TYPE_CUSTOMER = 'customer';
    const TYPE_EXPERT = 'expert';

    const STATUS_PING = 'ping';
    const STATUS_VALIDATED = 'validated';
    const STATUS_REFUSED = 'refused';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'sub_total',
        'vat_total',
        'total',
        'currency',
        'order_id',
        'user_id',
    ];

    /**
     * Get the items for the invoice.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the order that owns the invoice.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that owns the invoice.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
