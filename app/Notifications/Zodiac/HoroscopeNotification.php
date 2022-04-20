<?php

namespace App\Notifications\Zodiac;

use App\Models\Zodiac\Horoscope;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Intervention\Zodiac\Laravel\ZodiacFacade;

class HoroscopeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Horoscope|null
     */
    private $horoscope;

    public function __construct(Horoscope $horoscope)
    {
        $this->horoscope = $horoscope;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $key = null;
        $content = null;
        if($this->horoscope){
            $zodiac = $notifiable->zodiac;
            $key = $zodiac->localized("fr");
            $key = Str::slug($key);
            $content = $this->horoscope->$key ?? null;
        }

        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'key' => $key,
            'content' => $content,
        ];

        return (new MailMessage)
            ->subject(__('emails.user.horoscope.subject', $data))
            ->markdown('emails.user.horoscope', ['user' => $notifiable, 'data' => $data,]);
    }

}
