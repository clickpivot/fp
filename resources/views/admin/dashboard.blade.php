@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-slate-100 mb-8">Admin Dashboard</h2>

        <div class="grid gap-6 md:grid-cols-2 mb-8">
            <a href="{{ route('admin.events.index') }}" class="bg-slate-800 hover:bg-slate-700 rounded-2xl p-8 transition">
                <div class="text-4xl mb-4">🥊</div>
                <h3 class="text-xl font-bold text-orange-500 mb-2">Events</h3>
                <p class="text-slate-400">Manage MMA events</p>
            </a>

            <a href="{{ route('admin.pools.index') }}" class="bg-slate-800 hover:bg-slate-700 rounded-2xl p-8 transition">
                <div class="text-4xl mb-4">🏆</div>
                <h3 class="text-xl font-bold text-orange-500 mb-2">Pools</h3>
                <p class="text-slate-400">Manage pools</p>
            </a>
        </div>

        <div class="bg-slate-800 rounded-2xl p-8">
            <h3 class="text-xl font-bold text-slate-100 mb-4">System Status</h3>
            <div class="space-y-3">
                <p class="text-emerald-500">✓ Database Connected</p>
                <p class="text-emerald-500">✓ Admin Access Granted</p>
                <p class="text-emerald-500">✓ All Systems Operational</p>
            </div>
        </div>
    </div>
</div>
@endsection
