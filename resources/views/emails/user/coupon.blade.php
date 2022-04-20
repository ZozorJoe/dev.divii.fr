@component('mail::message')
# {!! __('emails.greeting', $data) !!}

{!! __('emails.user.coupon.line.1', $data) !!}

{!! __('emails.user.coupon.line.2', $data) !!}

{!! __('emails.user.coupon.line.3', $data) !!}

{!! __('emails.user.coupon.line.4', $data) !!}

{!! __('emails.signature', $data) !!}
@endcomponent
