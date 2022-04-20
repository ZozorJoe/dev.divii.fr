<?php

namespace App\Models\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int value
 * @property int expired_value
 * @property int original_value
 * @property Carbon valid_until
 * @method static where(string $string, string $string1, \Illuminate\Support\Carbon $now)
 */
class Credit extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'valid_until' => 'datetime',
    ];

    /**
     * Get credit where value is positive
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopePositive(Builder $builder): Builder
    {
        return $builder->where('credits.value', '>', 0);
    }

    /**
     * Get valid credit
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeUsed(Builder $builder): Builder
    {
        return $builder->whereColumn('credits.value', '<', 'credits.original_value');
    }

    /**
     * Get valid credit
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeValid(Builder $builder): Builder
    {
        return $builder->where('credits.valid_until', '>', now());
    }

    /**
     * Get the user that owns the credit.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
