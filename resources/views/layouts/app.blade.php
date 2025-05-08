<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Money Calc Tools' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Money Calc Tools offers a comprehensive suite of financial calculators to help you make informed financial decisions.' }}">
    <meta name="keywords" content="{{ $keywords ?? 'financial calculators, tip calculator, mortgage calculator, loan calculator, investment calculator' }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors ">
<header class="bg-white dark:bg-gray-800 shadow py-4">
    <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">
            <a href="/" class="text-gray-900 dark:text-white">
                <img src="{{ asset('images/logo.jpg') }}" alt="Money Calc Tools Logo" class="h-8 inline-block mr-2">
            </a>
        </h1>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-6 ">
    @yield('content')
</main>

<footer class="text-center text-sm text-gray-500 py-4 ">
    &copy; {{ date('Y') }} Money Calc Tools. {{ __('All rights reserved.') }}
</footer>
</body>
</html>