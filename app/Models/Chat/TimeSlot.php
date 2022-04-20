<?php

namespace App\Models\Chat;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string start_at
 * @property string end_at
 * @property mixed weekday
 * @method static whereDoesntHave(string $string)
 */
class TimeSlot extends Model
{
    use HasFactory;

    const REPETITION_DAILY = 'daily';
    const REPETITION_WEEKLY = 'weekly';
    const REPETITION_MONTHLY = 'monthly';
    const REPETITION_YEARLY = 'yearly';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'repetition',
        'weekday',
        'start_at',
        'end_at',
    ];

    /**
     * Get the user that owns the slot.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
