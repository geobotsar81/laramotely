@component('mail::message') # Title: {{ $jobTitle }}

# Company: {{ $jobCompany }}

# Url: {{ $jobUrl }}

# Email:{{ $jobEmail }}

# Location: {{ $jobLocation }}

# Tags: {{ $jobTags }}

# Descriptioon:
{{ $jobDescription }}

{{ config("app.name") }}
@endcomponent
