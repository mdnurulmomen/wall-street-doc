<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Wall Street Doc</title>

         <!-- Fonts -->
         <link rel="preconnect" href="https://fonts.bunny.net">
         <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <!-- Scripts -->
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="flex items-center min-h-screen justify-center bg-gray-100">
        <div class="flex flex-col space-y-8">
            @auth
            <h1 class="text-5xl font-bold text-center text-gray-800">Welcome</h1>

            @else
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-white font-medium bg-lime-500 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">Login</a>

                <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-white font-medium bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">Register</a>
            </div>

            @endauth
        </div>
    </body>
</html>
