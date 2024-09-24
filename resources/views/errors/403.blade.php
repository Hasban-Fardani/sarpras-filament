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
        <h1 class="text-3xl font-bold">Anda tidak bisa mengakses halaman ini</h1>
        @auth
            @php
                $user = auth()->user();
            @endphp
            @can('admin', $user)
                <a href="/admin" class="bg-blue-600 mt-3 p-3 px-4 text-white rounded-lg">beranda</a>
            @endcan
            @can('supervisor', $user)
                <a href="/supervisor" class="bg-blue-600 mt-3 p-3 px-4 text-white rounded-lg">beranda</a>
            @endcan
            @can('division', $user)
                <a href="/division" class="bg-blue-600 mt-3 p-3 px-4 text-white rounded-lg">beranda</a>
            @endcan
        @endauth
    </main>
</body>

</html>
