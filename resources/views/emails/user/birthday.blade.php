@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.user.birthday.line.1', $data) !!}

{!! __('emails.user.birthday.line.2', $data) !!}

@component('mail::button', $data['url'])
{!! __('emails.user.birthday.button', $data) !!}
@endcomponent

{!! __('emails.user.birthday.line.3', $data) !!}

{!! __('emails.signature', $data) !!}
@endcomponent
