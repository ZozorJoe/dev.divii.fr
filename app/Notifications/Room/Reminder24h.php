<?php

namespace App\Notifications\Room;

use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Reminder24h extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Room
     */
    private $room;

    /**
     * @var int
     */
    private $time;

    public function __construct(Room $room, $time)
    {
        $this->room = $room;
        $this->time = $time;
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
        $tz = $notifiable->timezone ?? "Europe/Paris";
        $model = $this->room->model;
        switch (true){
            case $model instanceof Consultation:
                $item = strtolower(__('messages.consultation'));
                $count = trans_choice('messages.choices.consultation', 1, ['value' => 1]);
                break;
            case $model instanceof Formation:
            default:
                $item = strtolower(__('messages.cours'));
                $count = trans_choice('messages.choices.cours', 1, ['value' => 1]);
                break;
        }

        $start = $this->room->start_at->timezone($tz);
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'time' => $this->time,
            'item' => $item,
            'count' => $count,
            'date' => $start->format('d/m/Y'),
            'hour' => $start->format('H:i') . "($tz)",
            'expert' => $this->room->user->first_name,
            'url_view' => route('video.room', $this->room),
            'url_cancel' => route('chat.room.cancel', $this->room),
        ];
        return (new MailMessage)
            ->subject(__('emails.room.reminder-24h.subject', $data))
            ->markdown('emails.room.reminder-24h', ['user' => $notifiable, 'model' => $this->room, 'data' => $data, ]);
    }

}
