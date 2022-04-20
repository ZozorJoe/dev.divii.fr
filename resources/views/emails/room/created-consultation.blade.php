@component('mail::message')
# {!! __('emails.greeting', ['name' => $user->first_name]) !!}

{!! __('emails.room.created-consultation.line.1', $data) !!}

{!! __('emails.room.created-consultation.line.2', $data) !!}
{!! __('emails.room.created-consultation.line.3', $data) !!}

{!! __('emails.room.created-consultation.line.4', $data) !!}

{!! __('emails.signature', ['app_name' => config('app.name')]) !!}
@endcomponent
