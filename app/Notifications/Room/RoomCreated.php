<?php

namespace App\Notifications\Room;

use App\Models\Catalog\Formation;
use App\Models\Chat\Room;
use App\Models\Shop\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoomCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Room
     */
    private $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
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
            'date' => $start->format('d/m/Y'),
            'hour' => $start->format('H:i') . "($tz)",
            'expert' => $this->room->user->first_name,
        ];
        $model = $this->room->model;
        $data['id'] = $model->getKey();
        switch (true){
            case $model instanceof Consultation:
                return (new MailMessage)
                    ->subject(__('emails.room.created-consultation.subject', $data))
                    ->markdown('emails.room.created-consultation', ['user' => $notifiable, 'model' => $this->room, 'data' => $data]);
            case $model instanceof Formation:
            default:
                return (new MailMessage)
                    ->subject(__('emails.room.created-formation.subject', $data))
                    ->markdown('emails.room.created-formation', ['user' => $notifiable, 'model' => $this->room, 'data' => $data]);
        }
    }

}
