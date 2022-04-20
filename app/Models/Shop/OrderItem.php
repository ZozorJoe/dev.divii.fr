<?php

namespace App\Models\Shop;

use App\Models\Catalog\Formation;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $quantity
 * @property float|int $sub_total
 * @property mixed $price
 * @property mixed $vat
 * @property float|int $vat_total
 * @property float|int $row_total
 * @property mixed $currency
 * @property mixed $order_id
 * @property Formation|Product|Consultation orderable
 * @property mixed orderable_type
 */
class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'price',
        'sub_total',
        'vat',
        'vat_total',
        'row_total',
        'currency',
    ];

    /**
     * @param int $quantity
     */
    public function addQuantity(int $quantity)
    {
        $this->quantity += $quantity;
        $this->sub_total = $this->quantity * $this->price;
        $this->vat_total = ($this->vat * $this->sub_total) / 100;
        $this->row_total = $this->sub_total + $this->vat_total;
    }

    /**
     * Get the order that owns the item.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the owning orderable model.
     *
     * @return MorphTo
     */
    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }
}
