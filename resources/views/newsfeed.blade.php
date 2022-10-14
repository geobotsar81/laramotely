<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0">
<channel>
<title>laramotely.com Feed</title>
<link>https://www.laramotely.com/newsfeed</link>
<description>Latest news at laramotely.com</description>
<language>en-us</language>  
    @foreach ($news as $article)
    <item>
       
        <title><![CDATA[@php echo $article->title." - ".$article->category; @endphp]]></title>
       
        <link>{{ route('news.show-detail',$article->id) }}</link>
        <guid>{{ route('news.show-detail',$article->id) }}</guid>
        <pubDate>@php echo date('r', strtotime($article->posted_date)); @endphp</pubDate>
    </item>
    @endforeach
</channel>
</rss>