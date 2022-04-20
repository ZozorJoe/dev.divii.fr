@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.room.reminder-30m.line.1', $data) !!}

{!! __('emails.signature', $data) !!}
@endcomponent
