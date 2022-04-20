<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed user_id
 * @property Room room
 * @method static create(array $data)
 */
class Message extends Model
{
    use HasFactory;

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'room'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->user_id && auth()->check()) {
                /** @var User $user */
                $user = auth()->user();
                $model->user_id = $user->getKey();
            }
        });
    }

    /**
     * Get the room that owns the message.
     *
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Get the user that owns the message.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the users for the message.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'message_user', 'message_id')
            ->using(MessageUser::class)
            ->withTimestamps()
            ->withPivot(['is_seen']);
    }
}
