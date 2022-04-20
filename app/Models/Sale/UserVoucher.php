<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserVoucher extends Pivot
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'redeemed_at' => 'datetime',
    ];
}
