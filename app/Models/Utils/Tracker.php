<?php

namespace App\Models\Utils;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Tracker extends Model
{
    use HasFactory;

    const EVENT_ACCESS = 'access';

    const EVENT_ORDER = 'order';

    const EVENT_CLICK = 'click';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event',
        'status',
        'method',
        'host',
        'url',
        'title',
        'referer_host',
        'referer',
        'platform',
        'browser',
        'version',
        'ip',
    ];

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
