@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.auth.verify.line.1', $data) !!}

{!! __('emails.auth.verify.line.2', $data) !!}

@component('mail::button', $data)
{!! __('emails.auth.verify.button', $data) !!}
@endcomponent

{!! __('emails.signature', $data) !!}
@endcomponent
