<?php

namespace App\Models\User;

use App\Models\Chat\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed user_id
 * @property int|mixed expert_id
 * @property int|mixed room_id
 * @property mixed value
 * @property mixed|string status
 */
class Rating extends Model
{
    use HasFactory;

    const STATUS_PING = 'ping';
    const STATUS_REFUSED = 'refused';
    const STATUS_VALIDATED = 'validated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'comment',
        'value',
        'room_id',
        'expert_id',
        'user_id',
    ];

    /**
     * Get the expert that owns the rating.
     *
     * @return BelongsTo
     */
    public function expert(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expert_id');
    }

    /**
     * Get the room that owns the rating.
     *
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * Get the user that owns the rating.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
