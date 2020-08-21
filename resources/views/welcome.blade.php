<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BigTicket</title>

        <!-- Generic Favicon -->
        <link rel="icon" href="/bigticket-favicon-32.png" sizes="32x32">
        <link rel="icon" href="/bigticket-favicon-128x128.png" sizes="128x128">
        <link rel="icon" href="/bigticket-favicon-152x152.png" sizes="152x152">
        <link rel="icon" href="/bigticket-favicon-167x167.png" sizes="167x167">
        <link rel="icon" href="/bigticket-favicon-180x180.png" sizes="180x180">
        <link rel="icon" href="/bigticket-favicon-192x192.png" sizes="192x192">
        <link rel="icon" href="/bigticket-favicon-196x196.png" sizes="196x196">
        <!-- Android Favicon -->
        <link rel="shortcut icon" sizes="196x196" href=“/favicon-196x196.png">
        <!-- iOS Favicon -->
        <link rel="apple-touch-icon" href="/bigticket-favicon-128x128.png" sizes="128x128">
        <link rel="apple-touch-icon" href="/bigticket-favicon-152x152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="/bigticket-favicon-180x180.png" sizes="180x180">
        <!-- Windows 8 and IE 10 Favicon -->
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="/bigticket-favicon-152x152.png">
        <!-- Windows 8.1 and IE11+ Favicon -->
        <meta name="msapplication-config" content="/browserconfig.xml" />

        <!-- Stylesheets -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </head>
    <body>
        <div class="flex flex-col h-full w-full justify-center">
            @if(Route::has('login'))
                <div class="w-full bg-BOS-500 text-white absolute top-0 right-0 py-2 px-4">
                    @auth
                        <a href="{{ url('/') }}">Home</a> |
                        <a href="{{ route('logout') }}">Log Out</a>
                    @else
                        <a href="{{ route('login') }}">Log In</a>
                    @endauth
                </div>
            @endif

            <div class="w-full text-center">
                <span class="text-lg">
                    BigTicket
                </span>
            </div>
        </div>
    </body>
</html>
