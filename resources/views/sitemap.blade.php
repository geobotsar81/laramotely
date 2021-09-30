<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://www.laramotely.com/</loc>
        <lastmod>2021-09-19T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>https://www.laramotely.com/contact</loc>
        <lastmod>2021-09-19T06:05:08Z</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    @foreach ($jobs as $job)
    <url>
        <loc>https://www.laramotely.com/job/{{$job->id}}</loc>
        <lastmod>{{ gmdate('Y-m-d\TH:i:s\Z',strtotime($job->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
