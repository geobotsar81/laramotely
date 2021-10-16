@component('mail::message')

<h1>Check out today's Laravel jobs on laramotely.com</h1>

@foreach($jobs as $job)
{{ $job->title }}

@component('mail::button', ['url' => $job->id]) View Job @endcomponent @endforeach

{{ config("app.name") }}
@endcomponent
