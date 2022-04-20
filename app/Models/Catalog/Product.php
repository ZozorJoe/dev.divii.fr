<?php

namespace App\Models\Catalog;

use App\Models\Shop\InvoiceItem;
use App\Models\Shop\OrderItem;
use App\Traits\HasVoucher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @method static find($id)
 * @method static where(string $string, string $string1, $id)
 * @property int credit
 * @property int gift
 * @property mixed vat
 * @property mixed price
 */
class Product extends Model
{
    use HasFactory, HasVoucher;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'vat',
        'currency',
        'credit',
        'gift',
    ];

    /**
     * Get the invoice items of the product.
     */
    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceable');
    }

    /**
     * Get all of the model's order items.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    public function getTotalCredit()
    {
        return $this->credit + $this->gift;
    }
}
