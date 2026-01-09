@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-slate-100 mb-8">Manage Pools</h2>

        <div class="bg-slate-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Pool Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Event</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Entries</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($pools as $pool)
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4 font-semibold text-slate-100">{{ $pool->name }}</td>
                            <td class="px-6 py-4 text-slate-300">{{ $pool->event->name }}</td>
                            <td class="px-6 py-4 text-slate-300">{{ $pool->plays_count ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center text-slate-400">
                                No pools yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
