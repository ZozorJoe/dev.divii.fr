<?php

namespace App\Models\Sale;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property mixed code
 * @property Carbon expires_at
 * @property Model model
 * @method static where(string $string, string $string1, mixed $voucher)
 * @method static create(array $array)
 * @method static whereCode(array|bool|string $code)
 * @method static updateOrCreate(string[] $array, array $array1)
 */
class Voucher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'code',
        'data',
        'expires_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'data' => 'collection',
    ];

    /**
     * Check if code is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at && Carbon::now()->gte($this->expires_at);
    }

    /**
     * Check if code is not expired.
     *
     * @return bool
     */
    public function isNotExpired(): bool
    {
        return ! $this->isExpired();
    }

    /**
     * Get the owning model.
     *
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The users that belong to the voucher.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_voucher', 'voucher_id')
            ->using(UserVoucher::class)
            ->withTimestamps();
    }
}
