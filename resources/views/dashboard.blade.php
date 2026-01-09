@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-slate-100 mb-8">Dashboard</h2>

        <div class="bg-slate-800 rounded-2xl p-8">
            <h3 class="text-xl font-bold text-slate-100 mb-4">Welcome, {{ auth()->user()->name }}!</h3>
            <p class="text-slate-400">Your FightPool dashboard</p>
        </div>
    </div>
</div>
@endsection
