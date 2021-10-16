@component('mail::message')

    <h1>Check out today's jobs on laramotely.com</h1>

    @foreach($jobs as $job)

        @component('mail::panel')
           {{ $job->title }}
            {{ $job->location }}
        @endcomponent

    @endforeach

{{ config("app.name") }}
@endcomponent
