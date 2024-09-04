<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
 
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
        <title>{{ config('app.name') }} - Forbidden</title>
 
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
 
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
<body class="bg-gray-100 w-screen h-screen">
    <main class="flex flex-col items-center justify-center h-full">
        <h1 class="text-4xl font-bold">You dont have permission to access this page</h1>
        @auth
            @if (auth()->user()->role == 'admin')
                <a href="/admin" class="bg-blue-600">go home</a>
            @elseif (auth()->user()->role == 'supervisor')
                <a href="/supervisor" class="bg-blue-600">go home</a>
            @endif
        @endauth
    </main>
</body>
</html>