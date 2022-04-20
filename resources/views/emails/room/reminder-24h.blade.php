@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.room.reminder-24h.line.1', $data) !!}

{!! __('emails.room.reminder-24h.line.2', $data) !!}

{!! __('emails.room.reminder-24h.line.3', $data) !!}

{!! __('emails.signature', $data) !!}
@endcomponent
