<header class="bg-light shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h1 class="h4 mb-0 text-primary">{{ config('app.name') }}</h1>
        </a>
        
        <div class="d-flex align-items-center">
            @auth
                <span class="mx-3">{{ Auth::user()->name }}</span>
            @endauth
        </div>
    </div>
</header>