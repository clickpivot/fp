@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-slate-100">Manage Events</h2>
            <a href="{{ route('admin.events.create') }}" class="bg-orange-500 hover:bg-orange-400 text-slate-950 px-6 py-3 rounded-xl font-bold transition">
                + Create Event
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-500 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-800 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Event</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-100">{{ $event->name }}</div>
                                <div class="text-sm text-slate-400">{{ $event->fights_count ?? 0 }} fights</div>
                            </td>
                            <td class="px-6 py-4 text-slate-300">{{ $event->starts_at->format('M j, Y g:i A') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($event->status === 'completed') bg-emerald-500/20 text-emerald-500
                                    @elseif($event->status === 'open') bg-blue-500/20 text-blue-500
                                    @else bg-slate-700 text-slate-300
                                    @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-orange-500 hover:text-orange-400 font-semibold">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400">
                                No events yet. Create your first event!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
