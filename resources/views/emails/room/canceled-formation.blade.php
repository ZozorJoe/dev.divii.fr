@component('mail::message')
# {!! __('emails.greeting', ['name' => $user->first_name]) !!}

{!! __('emails.room.canceled-formation.line.1', $data) !!}

{!! __('emails.room.canceled-formation.line.2', $data) !!}

@component('mail::button', $data)
    {!! __('emails.room.canceled-formation.button', $data) !!}
@endcomponent

{!! __('emails.room.canceled-formation.line.3', $data) !!}

{!! __('emails.signature', ['app_name' => config('app.name')]) !!}
@endcomponent
