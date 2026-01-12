@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-slate-100 mb-8">Available Pools</h2>

        <div class="grid gap-6">
            @forelse($pools as $pool)
                <div class="bg-slate-800 rounded-2xl p-6 hover:bg-slate-700 transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-100">{{ $pool->name }}</h3>
                            <p class="text-slate-400 mt-1">{{ $pool->event->name }}</p>
                            <p class="text-sm text-slate-500 mt-1">{{ $pool->event->starts_at->format('M j, Y g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            @if($pool->entry_fee_cents > 0)
                                <p class="text-lg font-bold text-orange-500">${{ number_format($pool->entry_fee_cents / 100, 2) }}</p>
                            @else
                                <p class="text-lg font-bold text-emerald-500">FREE</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-sm text-slate-400">
                            {{ $pool->plays_count ?? 0 }} {{ Str::plural('entry', $pool->plays_count ?? 0) }}
                        </p>
                        <a href="/pools/{{ $pool->slug }}" class="bg-orange-500 hover:bg-orange-400 text-slate-950 px-6 py-2 rounded-lg font-semibold transition">
                            View Pool
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-slate-800 rounded-2xl p-12 text-center">
                    <p class="text-slate-400 text-lg">No pools available yet</p>
                    <p class="text-slate-500 text-sm mt-2">Check back soon for upcoming events!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
