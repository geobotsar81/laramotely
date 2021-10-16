@component('mail::message') @foreach($jobs as $job)
{{ $job->title }}
@endforeach

{{ config("app.name") }}
@endcomponent
