<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Welcome & Stats --}}
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-200 mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                <p class="text-gray-400">Ready to make some picks?</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-slate-800 rounded-lg p-6 border border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-500/20 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pools Joined</p>
                            <p class="text-2xl font-bold text-gray-200">{{ $totalPlays }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-lg p-6 border border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-500/20 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Pool Wins</p>
                            <p class="text-2xl font-bold text-gray-200">{{ $wins }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-lg p-6 border border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500/20 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Total Points</p>
                            <p class="text-2xl font-bold text-gray-200">{{ $totalPoints }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Active Pools (need picks or upcoming) --}}
                    <div class="bg-slate-800 rounded-lg border border-slate-700">
                        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                                </svg>
                                My Active Pools
                            </h3>
                            <a href="{{ route('pools.index') }}" class="text-sm text-orange-500 hover:text-orange-400">
                                Browse All →
                            </a>
                        </div>
                        <div class="divide-y divide-slate-700">
                            @forelse ($activePlays as $play)
                                <div class="p-4 hover:bg-slate-700/30 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-200">{{ $play->pool->name }}</h4>
                                            <p class="text-sm text-gray-400">{{ $play->pool->event->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $play->pool->event->event_date ? $play->pool->event->event_date->format('M j, Y') : 'Date TBA' }}
                                                @if ($play->pool->event->event_date && $play->pool->event->event_date->isToday())
                                                    <span class="text-orange-500 font-medium">• TODAY</span>
                                                @elseif ($play->pool->event->event_date && $play->pool->event->event_date->isTomorrow())
                                                    <span class="text-yellow-500">• Tomorrow</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if ($play->picks->isEmpty())
                                                <span class="bg-red-500/20 text-red-400 text-xs font-medium px-2 py-1 rounded">
                                                    No Picks
                                                </span>
                                            @elseif ($play->picks->count() < $play->pool->event->fights->count())
                                                <span class="bg-yellow-500/20 text-yellow-400 text-xs font-medium px-2 py-1 rounded">
                                                    Incomplete
                                                </span>
                                            @else
                                                <span class="bg-green-500/20 text-green-400 text-xs font-medium px-2 py-1 rounded">
                                                    Ready
                                                </span>
                                            @endif
                                            <a href="{{ route('plays.edit', $play) }}" class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                                                {{ $play->picks->isEmpty() ? 'Make Picks' : 'Edit Picks' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-400 mb-4">You haven't joined any upcoming pools yet.</p>
                                    <a href="{{ route('pools.index') }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                        Browse Pools
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Recent Results --}}
                    @if ($pastPlays->isNotEmpty())
                        <div class="bg-slate-800 rounded-lg border border-slate-700">
                            <div class="px-6 py-4 border-b border-slate-700">
                                <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Recent Results
                                </h3>
                            </div>
                            <div class="divide-y divide-slate-700">
                                @foreach ($pastPlays->take(5) as $play)
                                    <div class="p-4 hover:bg-slate-700/30 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-400">{{ $play->pool->name }}</h4>
                                                <p class="text-sm text-gray-500">{{ $play->pool->event->event_date ? $play->pool->event->event_date->format('M j, Y') : 'Date TBA' }}</p>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <div class="text-right">
                                                    <p class="text-lg font-bold text-gray-200">{{ $play->total_points }} pts</p>
                                                </div>
                                                <a href="{{ route('pools.leaderboard', $play->pool) }}" class="text-gray-400 hover:text-gray-300">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Upcoming Events --}}
                    <div class="bg-slate-800 rounded-lg border border-slate-700">
                        <div class="px-6 py-4 border-b border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                Upcoming Events
                            </h3>
                        </div>
                        <div class="divide-y divide-slate-700">
                            @forelse ($upcomingEvents as $event)
                                <div class="p-4">
                                    <h4 class="font-medium text-gray-200">{{ $event->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $event->event_date ? $event->event_date->format('M j, Y') : 'Date TBA' }}</p>
                                    @if ($event->pools->count() > 0)
                                        <div class="mt-2">
                                            <span class="text-xs text-orange-400">{{ $event->pools->count() }} pool(s) available</span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-4 text-center text-gray-400 text-sm">
                                    No upcoming events
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-slate-800 rounded-lg border border-slate-700 p-4">
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Actions</h4>
                        <div class="space-y-2">
                            <a href="{{ route('pools.index') }}" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors p-2 rounded hover:bg-slate-700">
                                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                Browse Pools
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors p-2 rounded hover:bg-slate-700">
                                <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
