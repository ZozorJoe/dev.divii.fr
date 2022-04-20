<?php

namespace App\Listeners\Zodiac;

use App\Events\Zodiac\HoroscopeCreated;
use App\Events\Zodiac\HoroscopeUpdated;
use App\Jobs\Zodiac\HoroscopePublished;
use App\Models\Zodiac\Horoscope;

class SendHoroscopeNotification
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        switch (true){
            case $event instanceof HoroscopeUpdated:
                // Send notification 1
                $horoscope = $event->horoscope;
                if($horoscope->status === Horoscope::STATUS_PUBLISHED){
                    dispatch(new HoroscopePublished($horoscope));
                }
            break;
            case $event instanceof HoroscopeCreated:
                // Send notification 2
                $horoscope = $event->horoscope;
                if($horoscope->status === Horoscope::STATUS_PUBLISHED){
                    dispatch(new HoroscopePublished($horoscope));
                }
            break;
        }
    }


}
