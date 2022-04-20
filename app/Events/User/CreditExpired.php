<?php

namespace App\Events\User;

use App\Models\User\Credit;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditExpired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Credit
     */
    public $credit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }
}
