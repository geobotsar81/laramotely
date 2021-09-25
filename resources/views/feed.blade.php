<?xml version="1.0"  encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"> 
<channel>
<title>laramotely.com Feed</title>
<link>https://www.laramotely.com/feed</link>
<atom:link href="https://www.laramotely.com/feed" rel="self" type="application/rss+xml" />
<description>Latest JObs laramotely.com</description>
<language>en-us</language>  
    @foreach ($jobs as $job)
    <item>
        <title><![CDATA[@php echo $job->company." is looking for a ".$job->title.". Location: ".$job->location; @endphp]]></title>
        <link>{{ route('job.show',$job->id) }}</link>
        <id>{{$job->id }}</id>
        <date>{{ $job->posted_date }}</date>
    </item>
    @endforeach
</channel>
</rss>