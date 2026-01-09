<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FightPool')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 min-h-screen text-slate-100">
    <nav class="bg-slate-900 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-500">FightPool</a>
                
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-orange-500 transition">Dashboard</a>
                        
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-300 hover:text-orange-500 transition">Admin</a>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-300 hover:text-orange-500 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-orange-500 transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-400 text-slate-950 px-4 py-2 rounded-lg font-semibold transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
