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
        <title><![CDATA[@php echo $job->company." is looking for a ".$job->title.". Location: ".$job->location; @endphp]]></title>
        <link>{{ route('job.show',$job->id) }}</link>
        <id>{{$job->id }}</id>
        <date>{{ $job->posted_date }}</date>
    </entry>
    @endforeach
</feed>