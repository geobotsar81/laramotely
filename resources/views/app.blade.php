<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}" />
        <link rel="mask-icon" href="{{ asset('img/favicons/safari-pinned-tab.svg') }}" color="#5bbad5" />
        <link rel="shortcut icon" href="{{ asset('img/favicons/favicon.ico') }}" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="msapplication-config" content="{{ asset('img/favicons/browserconfig.xml') }}" />
        <meta name="theme-color" content="#ffffff" />

        <meta property="og:type" content="website" />
        <meta property="og:title" content=" {{ !empty($title) ? setting('site.title').' - '.$title  : setting('site.title').' - Full Stack Web Developer' }}" />
        <meta property="og:url" content="{{ $url }}" />
        <meta property="og:site_name" content="{{ config('name') }}" />
        <meta property="og:description" content="{{ !empty($description) ? $description : setting('site.description') }}" />
        <meta property="og:image" content="{{ asset('img/ogImage.png') }}" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content=" {{ !empty($title) ? setting('site.title').' - '.$title  : setting('site.title').' - Full Stack Web Developer' }}" />
        <meta name="twitter:description" content="{{ !empty($description) ? $description : setting('site.description') }}" />
        <meta name="twitter:image:src" content="{{ asset('img/ogImage.png') }}" />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XDNT4JLJD4"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "G-XDNT4JLJD4");
        </script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
        <link href="{{ asset('assets/fontawesome-pro/css/all.min.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia @env ('local')
        <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
        @endenv
    </body>
</html>
