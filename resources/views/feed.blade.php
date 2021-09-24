<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <id>laramotely.com Feed</id>
    <link href="{{ url('/feed') }}"></link>
    <title><![CDATA[laramotely.com Feed]]></title>
    <description></description>
    <language></language>
    <updated>{{ $jobs->first()->updated_at->format('D, d M Y H:i:s +0000') }}</updated>
    @foreach ($jobs as $job)
    <entry>
        <title><![CDATA[@php echo $job->company." is looking for a ".$job->title.". Location: ".$job->location.". Read more at ".route('job.show',$job->id); @endphp]]></title>
        <link rel="alternate" href="{{ $job->url }}" />
        <id>{{ route('job.show',$job->id) }}</id>
        <author>
            <name> <![CDATA[laramotely.com]]></name>
        </author>
        <updated>{{ $job->updated_at->format('D, d M Y H:i:s +0000') }}</updated>
    </entry>
    @endforeach
</feed>