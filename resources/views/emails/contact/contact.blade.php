@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! $data['content'] !!}

{!! __('emails.signature', $data) !!}
@endcomponent
