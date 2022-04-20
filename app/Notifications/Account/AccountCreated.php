<?php

namespace App\Notifications\Account;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __construct(Authenticatable $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
        switch ($notifiable->role){
            case User\Administrator::ROLE:
                $roles = __('messages.administrators');
            break;
            case User\Expert::ROLE:
                $roles = __('messages.experts');
            break;
            case User\Customer::ROLE:
            default:
                $roles = __('messages.members');
            break;
        }
        $data = [
            'app_name' => config('app.name'),
            'name' => $notifiable->first_name,
            'email' => $notifiable->email,
            'password' => $this->password,
            'url' => route('login'),
            'roles' => $roles,
        ];
        return (new MailMessage)
            ->subject(__('emails.account.created.subject', $data))
            ->markdown('emails.account.created', ['user' => $notifiable, 'data' => $data]);
    }

}
