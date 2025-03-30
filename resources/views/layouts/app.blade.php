<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name'))</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="antialiased">
    <div id="app">
        <!-- Шапка -->
        @include('layouts.header')
        
        <!-- Навигация -->
        @include('layouts.nav')
        
        <!-- Основное содержимое -->
        <main class="container py-4">
            <!-- Уведомления -->
            @include('partials.alerts')
            
            <!-- Контент страницы -->
            @yield('content')
        </main>
        
        <!-- Подвал -->
        @include('layouts.footer')
    </div>
    
    <!-- Дополнительные скрипты -->
    @stack('scripts')
</body>
</html>