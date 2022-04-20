<?php

namespace App\Models\Chat;

use App\Events\Chat\RoomCanceled;
use App\Models\Sale\Voucher;
use App\Models\Shop\InvoiceItem;
use App\Models\Shop\Order;
use App\Models\User;
use App\Traits\HasVoucher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property mixed users
 * @property int user_id
 * @property Carbon start_at
 * @property Carbon end_at
 * @property mixed model
 * @property mixed|string status
 * @property User user
 * @property Order order
 * @property mixed title
 * @method static create(array $data)
 * @method static findOrFail($roomId)
 * @method static firstOrCreate(array $array, array $array1)
 * @method static where(string $string, string $string1, mixed $getKey)
 * @method static find($roomId)
 */
class Room extends Model
{
    use HasFactory, HasVoucher;

    const STATUS_CANCELED = 'canceled';
    const STATUS_VALIDATED = 'validated';
    const STATUS_INVOICED = 'invoiced';
    const STATUS_COMPLETE = 'complete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'start_at',
        'end_at',
        'user_id',
        'model_type',
        'model_id',
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
     * @param $user
     * @return bool
     */
    public function attachUser($user): bool
    {
        if($user instanceof Model){
            $user_id = $user->getKey();
        }else{
            $user_id = $user;
        }

        $exists = $this->users()
            ->where('users.id', $user_id)
            ->exists();
        if(!$exists){
            $this->users()->attach($user_id);
            return true;
        }

        return false;
    }

    /**
     * @param $content
     * @param User $user
     */
    public function cancel($content, User $user)
    {
        event(new RoomCanceled($this, $content, $user));
        if($this->isAdmin($user) || $this->isExpert($user)){
            $this->status = Room::STATUS_CANCELED;
            $this->save();
        }else{
            $this->users()->detach($user->getKey());

            $count = $this->users()->count();
            if($count < 2){
                $this->delete();
            }
        }
    }

    /**
     * The customers that belong to the room.
     *
     * @return BelongsToMany
     */
    public function customers(): BelongsToMany
    {
        return $this->users()
            ->leftJoin('rooms AS r', 'r.id', '=', 'room_user.room_id')
            ->whereColumn('room_user.user_id', '!=', 'r.user_id');
    }

    /**
     * Get the invoice items of the room.
     */
    public function invoiceItems(): MorphMany
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceable');
    }

    /**
     * Check if user is not expert & not customer
     * @param User $user
     * @return bool
     */
    public function isAdmin(User $user): bool
    {
        return $user->isAdministrator() && !$this->isCustomer($user);
    }

    /**
     * Check if user is room's expert
     * @param User $user
     * @return bool
     */
    public function isExpert(User $user): bool
    {
        return $user && $user->getKey() === $this->user_id;
    }

    /**
     * Check if user is room's customer
     * @param User $user
     * @return bool
     */
    public function isCustomer(User $user): bool
    {
        return $this->users()
            ->where('users.id', '=', $user->getKey())
            ->exists();
    }

    /**
     * Get the latest messages for the room.
     */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)
            ->latestOfMany('created_at');
    }

    /**
     * Get the messages for the room.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'room_id');
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
     * The users that belong to the room.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user', 'room_id', 'user_id')
            ->using(RoomUser::class)
            ->withTimestamps();
    }

    /**
     * Get the expert that owns the room.
     * Alias user()
     *
     * @return BelongsTo
     */
    public function expert(): BelongsTo
    {
        return $this->user();
    }

    /**
     * Get the order that owns the room.
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get room with morph class
     *
     * @param Builder $builder
     * @param $morphClass
     * @return Builder
     */
    public function scopeOf(Builder $builder, $morphClass): Builder
    {
        $builder->whereHasMorph(
            'model',
            $morphClass,
        );

        return $builder;
    }

    /**
     * Get the user that owns the room.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the vouchers of the room.
     */
    public function vouchers(): MorphMany
    {
        return $this->morphMany(Voucher::class, 'model');
    }
}
