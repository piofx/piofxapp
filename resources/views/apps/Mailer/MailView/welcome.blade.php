@component('mail::message')
Hi {{$details['name']}},<br>

<h3>Welcome aboard. We’re thrilled to see you here!</h3>
<p>We’re confident that services will help you in your career growth.</p>

@component('mail::button', ['url' => url('/') ])
Get started now !
@endcomponent


Thanks,<br>
{{ $details['client_name'] }}
@endcomponent
