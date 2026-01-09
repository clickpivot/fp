@extends('layouts.app')

@section('content')
<div class="py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-6xl font-bold text-slate-100 mb-6">Welcome to FightPool</h1>
        <p class="text-2xl text-slate-400 mb-12">Predict UFC fight outcomes and compete with friends</p>
        
        <div class="flex gap-4 justify-center">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-orange-500 hover:bg-orange-400 text-slate-950 px-8 py-4 rounded-xl font-bold text-lg">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-400 text-slate-950 px-8 py-4 rounded-xl font-bold text-lg">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-100 px-8 py-4 rounded-xl font-bold text-lg">
                    Login
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
