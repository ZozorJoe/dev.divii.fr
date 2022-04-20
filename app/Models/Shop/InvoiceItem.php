<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property mixed invoiceable_type
 * @property mixed invoiceable_id
 * @property mixed quantity
 * @property mixed price
 * @property mixed sub_total
 * @property mixed row_total
 * @property mixed currency
 * @property mixed order_item_id
 * @property mixed invoice_id
 */
class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * Get the invoice that owns the item.
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the owning invoiceable model.
     *
     * @return MorphTo
     */
    public function invoiceable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the order item that owns the item.
     *
     * @return BelongsTo
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
