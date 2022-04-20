@component('mail::message')
# {!! __('emails.greeting', ['name' => $user->first_name]) !!}

{!! __('emails.account.created.line.1', $data) !!}

{!! __('emails.account.created.line.2', $data) !!}

{!! __('emails.account.created.line.3', $data) !!}

{!! __('emails.account.created.line.4', $data) !!}

{!! __('emails.account.created.line.5', $data) !!}

{!! __('emails.signature', ['app_name' => config('app.name')]) !!}
@endcomponent
