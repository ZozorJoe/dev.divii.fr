<?php

namespace App\Listeners\Contact;

use App\Events\Contact\Contact;
use App\Mail\Contact\ContactMail;
use Illuminate\Support\Facades\Mail;

class SendContactEmail
{
    /**
     * Handle the event.
     *
     * @param  Contact  $event
     * @return void
     */
    public function handle(Contact $event)
    {
        $emails = config('mail.contact.address');
        $emails = explode(',', $emails);
        foreach ($emails as $email){
            Mail::to($email)
                ->send(new ContactMail($event->user, $event->content));
        }
    }
}
