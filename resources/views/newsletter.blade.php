@component('mail::message')

<h1>Check out today's jobs on laramotely.com</h1>

@foreach($jobs as $job)

@component('mail::panel')
<div class="job__date">{{ $job->formated_date }}</div>
<h2>{{ $job->title }}</h2>

<div class="job__location">{{ $job->formated_location }}</div>
<div class="job__company">by {{ $job->company }}</div>
@endcomponent

@endforeach

{{ config("app.name") }}
@endcomponent
