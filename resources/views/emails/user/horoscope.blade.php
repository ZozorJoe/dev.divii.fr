@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.user.horoscope.line.1', $data) !!}

{!! $data['content'] ?? '' !!}

{!! __('emails.signature', $data) !!}
@endcomponent
