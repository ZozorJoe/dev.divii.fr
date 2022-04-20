<?php

namespace App\Models\Sale;

use App\Models\Shop\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed active
 * @property Carbon start_date
 * @property Carbon end_date
 * @property int limit_number
 * @property mixed times_used
 * @property mixed limit_user
 * @property mixed isValid
 * @property mixed required_qty
 * @property mixed type
 * @property mixed value
 * @property mixed name
 * @property mixed reduction
 * @method static whereName(string $voucher)
 * @method static where(string $string, string $string1, string $code)
 * @method static create(array $array)
 */
class Coupon extends Model
{
    use HasFactory;

    const TYPE_PERCENT = 'percent';
    const TYPE_FIX = 'fix';
    const TYPE_FREE = 'free';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'value',
        'active',
        'start_date',
        'end_date',
        'limit_number',
        'limit_user',
        'required_qty',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * @return bool
     */
    public function getReductionAttribute(): bool
    {
        $type = $this->type;
        $value = $this->value;

        if($type === Coupon::TYPE_PERCENT){
            return "$value%";
        }

        if($type === Coupon::TYPE_FIX){
            return "$value EUR";
        }

        return 'GRATUIT';
    }

    /**
     * @return bool
     */
    public function getIsValidAttribute(): bool
    {
        return $this->active &&
            $this->validDates() &&
            $this->validLimitNumber() &&
            $this->validLimitUser();
    }

    /**
     * @return bool
     */
    private function validDates(): bool
    {
        if (!$this->start_date || ($this->start_date > Carbon::now())) {
            return false;
        }

        return !$this->end_date || ($this->end_date > Carbon::now());
    }

    private function validLimitNumber(): bool
    {
        return ! $this->limit_number || $this->times_used < $this->limit_number;
    }

    public function validLimitUser(): bool
    {
        if (! $this->limit_user) {
            return true;
        }

        $couponUsed = CouponUser::where('coupon_id', '=', $this->getKey())
            ->where('user_id', Auth::user()->id)
            ->exists();
        return !$couponUsed;
    }

    public function isApplicable($total, $itemsCount): bool
    {
        if (! $this->isValid) {
            return false;
        }

        return $itemsCount >= $this->required_qty;
    }

    public function use($userId = null)
    {
        $this->times_used += 1;
        $this->save();

        if ($this->limit_user) {
            CouponUser::insert(
                ['user_id' => $userId, 'coupon_id' => $this->getKey()]
            );
        }
    }

    public function getDiscount($subtotal)
    {
        switch ($this->type) {
            case self::TYPE_PERCENT:
                return round($subtotal / 100 * $this->value, 2);
            case self::TYPE_FIX:
                return $this->value;
            case self::TYPE_FREE:
                return 0;
        }
        return $subtotal;
    }

    /**
     * Get the orders for the coupon.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_id');
    }

    /**
     * The users that belong to the voucher.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user', 'coupon_id')
            ->using(CouponUser::class)
            ->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->end_date && Carbon::now()->gte($this->end_date);
    }
}
