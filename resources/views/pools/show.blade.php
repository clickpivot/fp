<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    {{ $pool->name }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">{{ $pool->event->name }}</p>
            </div>
            <a href="{{ route('pools.index') }}" class="text-gray-400 hover:text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Pools
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div class="mb-6 bg-blue-500/20 border border-blue-500/50 text-blue-400 px-4 py-3 rounded-lg">
                    {{ session('info') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                {{-- Main Content --}}
                <div class="lg:col-span-2">
                    {{-- Pool Info Card --}}
                    <div class="bg-slate-800 rounded-lg p-6 border border-slate-700 mb-6">
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center text-gray-400">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                {{ $pool->event->event_date->format('l, F j, Y') }}
                            </div>
                            <div class="flex items-center text-gray-400">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                {{ $pool->event->location ?? 'Location TBA' }}
                            </div>
                            @if ($pool->entry_fee > 0)
                                <span class="bg-orange-500/20 text-orange-400 text-sm font-medium px-3 py-1 rounded">
                                    ${{ number_format($pool->entry_fee, 2) }} Entry
                                </span>
                            @else
                                <span class="bg-green-500/20 text-green-400 text-sm font-medium px-3 py-1 rounded">
                                    Free Entry
                                </span>
                            @endif
                        </div>

                        @if ($pool->description)
                            <p class="text-gray-400 mb-6">{{ $pool->description }}</p>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-3">
                            @if ($eventStarted)
                                <a href="{{ route('pools.leaderboard', $pool) }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                    </svg>
                                    View Leaderboard
                                </a>
                                @if ($hasJoined)
                                    <span class="inline-flex items-center bg-slate-700 text-gray-400 font-medium py-2 px-4 rounded-lg">
                                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                        </svg>
                                        Picks Locked
                                    </span>
                                @endif
                            @elseif ($hasJoined)
                                <a href="{{ route('plays.edit', $userPlay) }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Edit My Picks
                                </a>
                                <span class="inline-flex items-center text-green-400">
                                    <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Joined
                                </span>
                            @else
                                <form action="{{ route('pools.join', $pool) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Join Pool
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Fight Card --}}
                    <div class="bg-slate-800 rounded-lg border border-slate-700">
                        <div class="px-6 py-4 border-b border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                </svg>
                                Fight Card ({{ $pool->event->fights->count() }} Bouts)
                            </h3>
                        </div>
                        <div class="divide-y divide-slate-700">
                            @forelse ($pool->event->fights->sortByDesc('bout_order') as $fight)
                                <div class="p-4 hover:bg-slate-700/30 transition-colors">
                                    {{-- Fight Labels --}}
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @if ($fight->is_main_event)
                                            <span class="bg-red-500/20 text-red-400 text-xs font-medium px-2 py-0.5 rounded">
                                                MAIN EVENT
                                            </span>
                                        @endif
                                        @if ($fight->is_co_main)
                                            <span class="bg-purple-500/20 text-purple-400 text-xs font-medium px-2 py-0.5 rounded">
                                                CO-MAIN
                                            </span>
                                        @endif
                                        @if ($fight->is_swimmies)
                                            <span class="bg-blue-500/20 text-blue-400 text-xs font-medium px-2 py-0.5 rounded">
                                                SWIMMIES
                                            </span>
                                        @endif
                                        <span class="text-gray-500 text-xs">
                                            {{ $fight->weight_class }}
                                        </span>
                                    </div>

                                    {{-- Fighters --}}
                                    <div class="flex items-center justify-between">
                                        {{-- Red Corner --}}
                                        <div class="flex-1 text-left">
                                            <div class="flex items-center">
                                                <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                                <span class="font-medium text-gray-200 {{ $fight->winner === 'red' ? 'text-green-400' : '' }}">
                                                    {{ $fight->red_fighter }}
                                                </span>
                                                @if ($fight->winner === 'red')
                                                    <svg class="w-4 h-4 ml-2 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            @if ($fight->red_odds)
                                                <span class="text-xs text-gray-500 ml-5">{{ $fight->red_odds }}</span>
                                            @endif
                                        </div>

                                        {{-- VS --}}
                                        <div class="px-4">
                                            <span class="text-gray-500 text-sm font-medium">VS</span>
                                        </div>

                                        {{-- Blue Corner --}}
                                        <div class="flex-1 text-right">
                                            <div class="flex items-center justify-end">
                                                @if ($fight->winner === 'blue')
                                                    <svg class="w-4 h-4 mr-2 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                                <span class="font-medium text-gray-200 {{ $fight->winner === 'blue' ? 'text-green-400' : '' }}">
                                                    {{ $fight->blue_fighter }}
                                                </span>
                                                <span class="w-3 h-3 bg-blue-500 rounded-full ml-2"></span>
                                            </div>
                                            @if ($fight->blue_odds)
                                                <span class="text-xs text-gray-500 mr-5">{{ $fight->blue_odds }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Result --}}
                                    @if ($fight->winner && $fight->method)
                                        <div class="mt-2 text-center">
                                            <span class="text-xs text-gray-500">
                                                {{ $fight->method }}
                                                @if ($fight->round)
                                                    (R{{ $fight->round }})
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p>No fights have been added to this event yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-1">
                    {{-- Participants --}}
                    <div class="bg-slate-800 rounded-lg border border-slate-700">
                        <div class="px-6 py-4 border-b border-slate-700">
                            <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Participants ({{ $pool->plays->count() }})
                            </h3>
                        </div>
                        <div class="p-4">
                            @if ($pool->plays->isEmpty())
                                <p class="text-gray-400 text-sm text-center py-4">No one has joined yet. Be the first!</p>
                            @else
                                <ul class="space-y-2">
                                    @foreach ($pool->plays as $play)
                                        <li class="flex items-center text-gray-300">
                                            <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-sm font-medium text-gray-400">
                                                    {{ strtoupper(substr($play->user->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <span class="{{ $play->user_id === auth()->id() ? 'text-orange-400 font-medium' : '' }}">
                                                {{ $play->user->name }}
                                                @if ($play->user_id === auth()->id())
                                                    <span class="text-xs">(You)</span>
                                                @endif
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="mt-6 bg-slate-800 rounded-lg border border-slate-700 p-4">
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Links</h4>
                        <div class="space-y-2">
                            <a href="{{ route('pools.leaderboard', $pool) }}" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                                </svg>
                                Leaderboard
                            </a>
                            <a href="{{ route('pools.index') }}" class="flex items-center text-gray-300 hover:text-orange-400 transition-colors">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                                All Pools
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
