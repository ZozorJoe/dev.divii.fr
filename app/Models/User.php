<?php

namespace App\Models;

use App\Events\Sale\VoucherRedeemed;
use App\Exceptions\Voucher\VoucherAlreadyRedeemed;
use App\Exceptions\Voucher\VoucherExpired;
use App\Exceptions\Voucher\VoucherIsInvalid;
use App\Facades\Code;
use App\Facades\Vouchers;
use App\Models\Catalog\Discipline;
use App\Models\Catalog\Formation;
use App\Models\Chat\Message;
use App\Models\Chat\MessageUser;
use App\Models\Chat\Room;
use App\Models\Chat\RoomUser;
use App\Models\Chat\TimeSlot;
use App\Models\File\File;
use App\Models\Sale\Coupon;
use App\Models\Sale\CouponUser;
use App\Models\Sale\UserVoucher;
use App\Models\Sale\Voucher;
use App\Models\Shop\Invoice;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Models\User\Administrator;
use App\Models\User\Credit;
use App\Models\User\Customer;
use App\Models\User\DisciplineUser;
use App\Models\User\Expert;
use App\Models\User\Rating;
use App\Models\Utils\Tracker;
use App\Models\Zodiac\Horoscope;
use App\Models\Zodiac\HoroscopeUser;
use App\Notifications\User\ResetPassword;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Intervention\Zodiac\Laravel\Traits\CanResolveZodiac;
use Laravel\Sanctum\HasApiTokens;
use function Clue\StreamFilter\fun;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $op, mixed $get = null)
 * @method static findOrFail($id)
 * @method static whereNotNull(string $string)
 * @method static whereHas(string $string, \Closure $param)
 * @property string role
 * @property string first_name
 * @property string last_name
 * @property string name
 * @property File avatar
 * @property File picto
 * @property mixed id
 * @property Carbon last_activity
 * @property int credit
 * @property mixed email
 * @property mixed timeSlots
 * @property mixed background_color
 * @property Carbon|mixed email_verified_at
 * @property bool|mixed is_tester
 * @property mixed is_active
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResolveZodiac;

    const ROLE = 'user';
    const CHANNEL_REGISTRATION = 'registration';
    const CHANNEL_LAUNCH = 'launch';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active',
        'order',
        'first_name',
        'last_name',
        'role',
        'birthday',
        'birth_hour',
        'birth_place',
        'phone',
        'email',
        'description',
        'password',
        'avatar_id',
        'picto_id',
        'background_color',
        'arc',
        'rib',
        'code',
        'main_id',
        'is_tester',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'last_activity' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        if (static::ROLE != self::ROLE) {
            static::addGlobalScope('role', function (Builder $builder) {
                $builder->where('users.role', '=', static::ROLE);
            });
        }

        static::creating(function ($model){
            if (!$model->code) {
                $model->code = Code::generate();
            }
        });
    }

    /**
     * Get available attribute
     *
     * @return bool
     */
    public function getAvailableAttribute(): bool
    {
        $date = now()->setSecond(0)->addMinutes(15);
        $minute = $date->minute;
        switch ($minute){
            case $minute < 15:
                $date = now()->setMinute(15);
            break;
            case $minute < 30:
                $date = now()->setMinute(30);
            break;
            case $minute < 45:
                $date = now()->setMinute(45);
            break;
            default:
                $date = now()->setMinute(0)->addHour();
            break;
        }

        $builder = $this->rooms();
        $builder->where('rooms.status', '=', Room::STATUS_VALIDATED);
        $builder->where('rooms.start_at', '<=', $date);
        $builder->where('rooms.end_at', '>', $date);
        $exists = $builder->exists();
        if($exists){
            return false;
        }

        $builder = $this->timeSlots();
        $builder->whereRaw('WEEKDAY(start_at) = ?', $date->weekday());
        $builder->whereRaw('DATE_FORMAT(start_at, "%H:%i") <= ?', $date->format('H:i'));
        $builder->whereRaw('DATE_FORMAT(end_at, "%H:%i") > ?', $date->format('H:i'));
        return $builder->exists();
    }

    /**
     * Get name attribute
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): ?string
    {
        /**
         * @var File $avatar
         */
        $avatar = $this->avatar()->first();
        return $avatar ? url($avatar->path) : url('/img/avatar.jpg');
    }

    /**
     * Check if has new message attribute
     *
     * @return string
     */
    public function getHasNewMessageAttribute(): ?string
    {
        return $this->unreadMessages()
            ->wherePivot('is_seen', false)
            ->exists();
    }

    /**
     * Get user's credit
     *
     * @return int
     */
    public function getCreditAttribute(): int
    {
        return $this->credits()
            ->positive()
            ->valid()
            ->sum('credits.value');
    }

    /**
     * Get name attribute
     *
     * @return string
     */
    public function getNameAttribute(): ?string
    {
        return trim(__(':first_name :last_name', ['first_name' => $this->first_name, 'last_name' => $this->last_name, ]));
    }

    /**
     * Get online attribute
     *
     * @return string
     */
    public function getOnlineAttribute(): ?string
    {
        return $this->last_activity && $this->last_activity->isAfter(now()->subMinute(5));
    }

    /**
     * Get the avatar that owns the user.
     *
     * @return BelongsTo
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(File::class, 'avatar_id');
    }

    /**
     * Check if an user can join room
     *
     * @param $roomId
     * @return $this|null
     */
    public function canJoin($roomId): ?User
    {
        /** @var Room $room */
        $room = Room::find($roomId);
        if($room && $room->user_id == $this->getKey()){
            return $this;
        }

        if($this->rooms()->find($roomId)){
            return $this;
        }
        return null;
    }

    /**
     * Get all children of the user.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(User::class, 'main_id');
    }

    /**
     * The vouchers that belong to the user.
     *
     * @return BelongsToMany
     */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user', 'user_id')
            ->using(CouponUser::class)
            ->withTimestamps();
    }

    /**
     * Get the credits for the user.
     *
     * @return HasMany
     */
    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class, 'user_id');
    }

    /**
     * The disciplines that belong to the formation.
     *
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany
    {
        return $this->belongsToMany(Discipline::class, 'discipline_user', 'user_id')
            ->using(DisciplineUser::class)
            ->withPivot('durations')
            ->withPivot('with_preparation')
            ->withTimestamps();
    }

    /**
     * Get the formations for the user.
     *
     * @return HasMany
     */
    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'user_id');
    }

    /**
     * The horoscopes that belong to the user.
     *
     * @return BelongsToMany
     */
    public function horoscopes(): BelongsToMany
    {
        return $this->belongsToMany(Horoscope::class, 'horoscope_user', 'user_id')
            ->using(HoroscopeUser::class)
            ->withPivot('is_sent')
            ->withTimestamps();
    }

    /**
     * Get invoices for the user.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->role === Administrator::ROLE;
    }

    /**
     * @return bool
     */
    public function isCustomer(): bool
    {
        return $this->role === Customer::ROLE;
    }

    /**
     * @return bool
     */
    public function isExpert(): bool
    {
        return $this->role === Expert::ROLE;
    }

    /**
     * Check if user has role
     */
    public function hasRole($role): bool
    {
        return $role === $this->role;
    }

    /**
     * Get the user that owns the user.
     *
     * @return BelongsTo
     */
    public function main(): BelongsTo
    {
        return $this->belongsTo(User::class, 'main_id');
    }

    /**
     * Get the messages for the user.
     *
     * @return BelongsToMany
     */
    public function unreadMessages(): BelongsToMany
    {
        return $this->belongsToMany(Message::class, 'message_user', 'user_id')
            ->using(MessageUser::class)
            ->withTimestamps()
            ->withPivot(['is_seen']);
    }

    /**
     * Get the messages for the user.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the orders for the user.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the payments for the user.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the picto that owns the user.
     *
     * @return BelongsTo
     */
    public function picto(): BelongsTo
    {
        return $this->belongsTo(File::class, 'picto_id');
    }

    /**
     * Get the ratings for the user.
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'expert_id');
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.'.$this->getKey();
    }
    /**
     * @param string $code
     * @throws VoucherExpired
     * @throws VoucherIsInvalid
     * @throws VoucherAlreadyRedeemed
     * @return mixed
     */
    public function redeemCode(string $code)
    {
        $voucher = Vouchers::check($code);

        if ($voucher->users()->wherePivot('user_id', $this->id)->exists()) {
            throw VoucherAlreadyRedeemed::create($voucher);
        }

        $this->vouchers()->attach($voucher);

        event(new VoucherRedeemed($this, $voucher));

        return $voucher;
    }

    /**
     * @param Voucher $voucher
     * @throws VoucherExpired
     * @throws VoucherIsInvalid
     * @throws VoucherAlreadyRedeemed
     * @return mixed
     */
    public function redeemVoucher(Voucher $voucher)
    {
        return $this->redeemCode($voucher->code);
    }

    /**
     * The rooms that belong to the user.
     *
     * @return BelongsToMany
     */
    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_user', 'user_id')
            ->using(RoomUser::class)
            ->withTimestamps();
    }

    /**
     * @return string[]
     */
    public function scopes(): array
    {
        return ['*'];
    }

    /**
     * Send the password reset notification.
     *
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Get all time slots of the user.
     */
    public function timeSlots(): HasMany
    {
        return $this->hasMany(TimeSlot::class, 'user_id');
    }

    /**
     * Get the trackers for the user.
     *
     * @return HasMany
     */
    public function trackers(): HasMany
    {
        return $this->hasMany(Tracker::class, 'user_id');
    }

    /**
     * The vouchers that belong to the user.
     *
     * @return BelongsToMany
     */
    public function vouchers(): BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'user_voucher', 'user_id')
            ->using(UserVoucher::class)
            ->withTimestamps();
    }
}
