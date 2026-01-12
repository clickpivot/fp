<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Browse Pools
        </h2>
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

            {{-- Upcoming Pools --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                    </svg>
                    Upcoming Pools
                </h3>

                @if ($upcomingPools->isEmpty())
                    <div class="bg-slate-800 rounded-lg p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <p class="text-gray-400">No upcoming pools available. Check back soon!</p>
                    </div>
                @else
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($upcomingPools as $pool)
                            <div class="bg-slate-800 rounded-lg p-6 border border-slate-700 hover:border-orange-500/50 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-200">{{ $pool->name }}</h4>
                                        <p class="text-sm text-gray-400">{{ $pool->event->name }}</p>
                                    </div>
                                    @if ($pool->entry_fee > 0)
                                        <span class="bg-orange-500/20 text-orange-400 text-sm font-medium px-2.5 py-0.5 rounded">
                                            ${{ number_format($pool->entry_fee, 2) }}
                                        </span>
                                    @else
                                        <span class="bg-green-500/20 text-green-400 text-sm font-medium px-2.5 py-0.5 rounded">
                                            Free
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center text-sm text-gray-400 mb-4 space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        {{ $pool->event->event_date->format('M j, Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        {{ $pool->plays->count() }} players
                                    </span>
                                </div>

                                <a href="{{ route('pools.show', $pool) }}" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    View Pool
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Past Pools --}}
            @if ($pastPools->isNotEmpty())
                <div>
                    <h3 class="text-lg font-semibold text-gray-200 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Recent Pools
                    </h3>

                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($pastPools as $pool)
                            <div class="bg-slate-800/50 rounded-lg p-6 border border-slate-700/50">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-400">{{ $pool->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $pool->event->name }}</p>
                                    </div>
                                    <span class="bg-gray-500/20 text-gray-400 text-sm font-medium px-2.5 py-0.5 rounded">
                                        Completed
                                    </span>
                                </div>

                                <div class="flex items-center text-sm text-gray-500 mb-4 space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        {{ $pool->event->event_date->format('M j, Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        {{ $pool->plays->count() }} players
                                    </span>
                                </div>

                                <a href="{{ route('pools.leaderboard', $pool) }}" class="block w-full text-center bg-slate-700 hover:bg-slate-600 text-gray-300 font-medium py-2 px-4 rounded-lg transition-colors">
                                    View Results
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
