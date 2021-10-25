@component('mail::message')

<h1>Check out our latest jobs on laramotely.com</h1>

@foreach($jobs as $job) @component('mail::panel')
<div class="job">
<div class="job__date">{{ $job->formated_date }}</div>
<h2>{{ $job->title }}</h2>

<div class="job__location">{{ $job->formated_location }}</div>
<div class="job__company">by {{ $job->company }}</div>
@component('mail::button', ['url' => 'https://www.laramotely.com/job/'.$job->id."?ref=nsl"]) View Job @endcomponent
</div>
@endcomponent @endforeach
<div class="job__reminder">You are receiving this email because you have subscribed to our daily jobs newsletter via our website.</div>
<div class="job__unsubscribe"><a href="{{ route('newsletter.unsubscribe', $contactLink) }}">unsubscribe</a></div>
@endcomponent
