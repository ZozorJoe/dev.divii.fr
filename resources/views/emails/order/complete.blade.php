@component('mail::message')
# {!! __('emails.greeting', ['name' => $user->first_name]) !!}

{!! __('emails.order.complete.line.1', $data) !!}

{!! __('emails.order.complete.line.2', $data) !!}
{!! __('emails.order.complete.line.3', $data) !!}

{!! __('emails.order.complete.line.4', $data) !!}

{!! __('emails.signature', ['app_name' => config('app.name')]) !!}
@endcomponent
