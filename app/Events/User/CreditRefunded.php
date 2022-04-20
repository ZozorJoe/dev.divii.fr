<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditRefunded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $customer;

    /**
     * @var User
     */
    public $canceler;

    /**
     * @var int
     */
    public $credit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $customer, int $credit, User $canceler)
    {
        $this->customer = $customer;
        $this->canceler = $canceler;
        $this->credit = $credit;
    }
}
