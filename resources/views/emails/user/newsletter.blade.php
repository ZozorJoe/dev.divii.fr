@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.user.newsletter.line.1', $data) !!}

{!! __('emails.user.newsletter.line.2', $data) !!}

@component('mail::button', ['url' => $data['url']])
{!! __('emails.user.newsletter.button', $data) !!}
@endcomponent

{!! __('emails.signature', $data) !!}
@endcomponent
