<?php

namespace App\Models\Catalog;

use App\Models\Chat\Room;
use App\Models\File\File;
use App\Models\Shop\InvoiceItem;
use App\Models\Shop\OrderItem;
use App\Models\User;
use App\Traits\HasVoucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @method static create(array $data)
 * @method static find($id)
 * @method static where(string $string, string $string1, string $start)
 * @property mixed name
 * @property mixed description
 * @property mixed price
 * @property mixed vat
 * @property Carbon start_at
 * @property Carbon end_at
 * @property mixed user_id
 * @property File image
 * @property User user
 * @property File picto
 */
class Formation extends Model
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
        'start_at',
        'end_at',
        'user_id',
        'image_id',
        'picto_id',
        'background_color',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Get name attribute
     *
     * @return string
     */
    public function getImageUrlAttribute(): ?string
    {
        /**
         * @var File $image
         */
        $image = $this->image()->first();
        return $image ? url($image->path) : url('/img/avatar.jpg');
    }

    /**
     * Get all of the model's order items.
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * The disciplines that belong to the formation.
     *
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany
    {
        return $this->belongsToMany(Discipline::class, 'discipline_formation')
            ->using(DisciplineFormation::class)
            ->withTimestamps();
    }

    /**
     * Get the expert that owns the formation.
     * @alias function user()
     *
     * @return BelongsTo
     */
    public function expert(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Get the image that owns the formation.
     *
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /**
     * Get the invoice items of the formation.
     */
    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceable');
    }

    /**
     * Get the picto that owns the formation.
     *
     * @return BelongsTo
     */
    public function picto(): BelongsTo
    {
        return $this->belongsTo(File::class, 'picto_id');
    }

    /**
     * Get the formation's room.
     */
    public function room(): MorphOne
    {
        return $this->morphOne(Room::class, 'model');
    }

    /**
     * Get the user that owns the formation.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
