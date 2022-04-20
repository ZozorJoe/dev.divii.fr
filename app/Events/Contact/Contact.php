<?php

namespace App\Events\Contact;

use App\Models\Shop\Consultation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Contact
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $content;

    /**
     * ConsultationCompleted constructor.
     * @param $user
     * @param $content
     */
    public function __construct($user, $content)
    {
        $this->user = $user;
        $this->content = $content;
    }
}
