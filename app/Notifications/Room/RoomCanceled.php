<?php

namespace App\Notifications\Room;

use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoomCanceled extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Room
     */
    private $room;

    /**
     * @var string
     */
    private $content;

    public function __construct(Room $room, ?string $content)
    {
        $this->room = $room;
        $this->content = $content;
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
        $start = $this->room->start_at->timezone($tz);
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'content' => $this->content,
            'datetime' => $start->format('d/m/Y H:i') . "($tz)",
            'expert' => $this->room->user->first_name,
            'url' => route('calendar'),
        ];
        $model = $this->room->model;
        switch (true){
            case $model instanceof Consultation:
                $data['url'] = route('experts.index');
                return (new MailMessage)
                    ->subject(__('emails.room.canceled-consultation.subject', $data))
                    ->markdown('emails.room.canceled-consultation', ['user' => $notifiable, 'model' => $this->room, 'data' => $data]);
            case $model instanceof Formation:
            default:
                $data['url'] = route('calendar');
                return (new MailMessage)
                    ->subject(__('emails.room.canceled-formation.subject', $data))
                    ->markdown('emails.room.canceled-formation', ['user' => $notifiable, 'model' => $this->room, 'data' => $data]);
        }

    }

}
