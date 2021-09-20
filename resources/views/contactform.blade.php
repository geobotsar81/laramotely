@component('mail::message')
# {{$subject}}

## {{$message}}

Feel free to contact me via {{$email}}

Thanks,<br>
{{$fullname}}

{{ config('app.name') }}
@endcomponent