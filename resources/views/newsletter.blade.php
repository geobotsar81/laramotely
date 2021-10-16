@component('mail::message')

    <h1>Check out today's jobs on laramotely.com</h1>

    @foreach($jobs as $job)

        <h2>{{ $job->title }}</h2>
        {{ $job->location }}

            @component('mail::button', ['url' => 'https://www.laramotely.com/job/'.$job->id]) 
            View Job 
            @endcomponent 

    @endforeach

{{ config("app.name") }}
@endcomponent
