<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Запази час</title>

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Запази час</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/bookings') }}">Часове</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <h1 class="display-4 text-primary">
        <a href="{{ route('bookings.index') }}" class="text-primary text-decoration-none">Запази час</a>
    </h1>
</div>

<!-- Bootstrap JS (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
