<?php

namespace App\Models\Zodiac;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed status
 */
class Horoscope extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'belier', 'taureau', 'gemeaux',
        'cancer', 'lion', 'vierge',
        'balance', 'scorpion', 'sagittaire',
        'capricorne', 'verseau', 'poissons',
    ];

    /**
     * The users that belong to the horoscope.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Horoscope::class, 'horoscope_user', 'horoscope_id')
            ->using(HoroscopeUser::class)
            ->withPivot('is_sent')
            ->withTimestamps();
    }
}
