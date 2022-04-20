<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed durations
 * @property mixed with_preparation
 * @method static where(string $string, string $string1, mixed $getKey)
 */
class DisciplineUser extends Pivot
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'durations',
        'with_preparation',
        'discipline_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'durations' => 'array',
        'with_preparation' => 'boolean',
    ];
}
