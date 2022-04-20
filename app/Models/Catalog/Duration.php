<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(mixed $duration_id)
 * @property mixed credit
 * @property mixed label
 * @property mixed delay
 */
class Duration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'credit',
        'price',
        'vat',
        'currency',
        'delay',
    ];
}
