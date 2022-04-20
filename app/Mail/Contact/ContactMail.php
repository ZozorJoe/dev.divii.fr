<?php

namespace App\Mail\Contact;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $content)
    {
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'app_name' => config('app.name'),
            'name' => $this->user->name,
            'content' => $this->content,
        ];

        return $this->markdown('emails.contact.contact', ['data' => $data]);
    }
}
