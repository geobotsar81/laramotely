<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
<channel>
<title>laramotely.com Feed</title>
<link>https://www.laramotely.com/feed</link>
<description>Latest jobs at laramotely.com</description>
<language>en-us</language>  
    @foreach ($jobs as $job)
    <item>
        <title><![CDATA[@php echo $job->company." is looking for a ".$job->title.". Location: ".$job->location; @endphp]]></title>
        <link>{{ route('job.show',$job->id) }}</link>
        <guid>{{ route('job.show',$job->id) }}</guid>
        <pubDate>@php echo date('r', strtotime($job->posted_date)); @endphp</pubDate>
    </item>
    @endforeach
</channel>
</rss>