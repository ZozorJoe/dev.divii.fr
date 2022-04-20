<?php

namespace App\Events\Zodiac;

use App\Models\Zodiac\Horoscope;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HoroscopeCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The authenticated user.
     *
     * @var Horoscope
     */
    public $horoscope;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Horoscope $horoscope)
    {
        $this->horoscope = $horoscope;
    }
}
