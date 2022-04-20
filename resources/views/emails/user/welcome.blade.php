@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.welcome.line.1', $data) !!}

{!! __('emails.welcome.line.2', $data) !!}

{!! __('emails.signature', $data) !!}
@endcomponent
