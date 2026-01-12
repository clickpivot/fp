@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-slate-100 mb-8">My Dashboard</h2>

        <div class="bg-slate-800 rounded-2xl p-8 mb-6">
            <h3 class="text-xl font-bold text-slate-100 mb-4">Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-slate-400">Your FightPool dashboard</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <a href="/pools" class="bg-slate-800 hover:bg-slate-700 rounded-2xl p-8 transition">
                <div class="text-4xl mb-4">🏆</div>
                <h3 class="text-xl font-bold text-orange-500 mb-2">Browse Pools</h3>
                <p class="text-slate-400">Join a pool and make your picks</p>
            </a>

            <div class="bg-slate-800 rounded-2xl p-8 opacity-50">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-xl font-bold text-slate-500 mb-2">My Pools</h3>
                <p class="text-slate-400">Coming soon</p>
            </div>
        </div>
    </div>
</div>
@endsection
