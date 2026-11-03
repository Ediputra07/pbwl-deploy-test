<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Praktikum PBWL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@auth
<nav class="navbar bg-light border-bottom">
    <div class="container d-flex justify-content-between">
        <a href="{{ route('dashboard') }}" class="navbar-brand">Dashboard</a>
        <span>
            {{ Auth::user()->name }}
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-secondary ms-2">Logout</button>
            </form>
        </span>
    </div>
</nav>
@endauth
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>
@stack('scripts')
</body>
</html>
