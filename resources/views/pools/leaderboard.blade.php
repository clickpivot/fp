<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    Leaderboard
                </h2>
                <p class="text-sm text-gray-400 mt-1">{{ $pool->name }} &bull; {{ $pool->event->name }}</p>
            </div>
            <a href="{{ route('pools.show', $pool) }}" class="text-gray-400 hover:text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Pool
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$eventCompleted)
                <div class="mb-6 bg-yellow-500/20 border border-yellow-500/50 text-yellow-400 px-4 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    Event in progress. Results will update as fights are completed.
                </div>
            @endif

            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-200 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                        </svg>
                        Rankings
                    </h3>
                </div>

                @if ($plays->isEmpty())
                    <div class="p-8 text-center text-gray-400">
                        <p>No participants yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Player</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Points</th>
                                    @foreach ($pool->event->fights->sortBy('bout_order') as $fight)
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider whitespace-nowrap" title="{{ $fight->red_fighter }} vs {{ $fight->blue_fighter }}">
                                            <span class="hidden lg:inline">{{ Str::limit($fight->red_fighter, 8) }}</span>
                                            <span class="lg:hidden">B{{ $fight->bout_order }}</span>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @foreach ($plays as $play)
                                    <tr class="{{ $play->user_id === auth()->id() ? 'bg-orange-500/10' : 'hover:bg-slate-700/30' }} transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($play->rank === 1)
                                                <span class="text-2xl">🥇</span>
                                            @elseif ($play->rank === 2)
                                                <span class="text-2xl">🥈</span>
                                            @elseif ($play->rank === 3)
                                                <span class="text-2xl">🥉</span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-8 h-8 text-gray-400 font-medium">{{ $play->rank }}</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-slate-700 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-sm font-medium text-gray-400">{{ strtoupper(substr($play->user->name, 0, 1)) }}</span>
                                                </div>
                                                <span class="{{ $play->user_id === auth()->id() ? 'text-orange-400 font-medium' : 'text-gray-200' }}">
                                                    {{ $play->user->name }}
                                                    @if ($play->user_id === auth()->id())
                                                        <span class="text-xs">(You)</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="text-lg font-bold text-gray-200">{{ $play->total_points }}</span>
                                        </td>

                                        @foreach ($pool->event->fights->sortBy('bout_order') as $fight)
                                            @php
                                                $pick = $play->picks->firstWhere('fight_id', $fight->id);
                                            @endphp
                                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                                @if ($pick)
                                                    @php
                                                        $isCorrect = $fight->winner && $pick->selection === $fight->winner;
                                                        $isWrong = $fight->winner && !in_array($fight->winner, ['nc', 'draw']) && $pick->selection !== $fight->winner;
                                                    @endphp
                                                    <div class="flex flex-col items-center">
                                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-medium
                                                            {{ $pick->selection === 'red' ? 'bg-red-500/30 text-red-400' : 'bg-blue-500/30 text-blue-400' }}
                                                            {{ $isCorrect ? 'ring-2 ring-green-500' : '' }}
                                                            {{ $isWrong ? 'ring-2 ring-red-500 opacity-50' : '' }}">
                                                            {{ $pick->selection === 'red' ? 'R' : 'B' }}
                                                        </span>
                                                        <span class="text-xs mt-1">
                                                            @if ($isCorrect)
                                                                <span class="text-green-400">+{{ $pick->points_earned }}</span>
                                                            @elseif ($isWrong)
                                                                <span class="text-red-400">0</span>
                                                            @else
                                                                <span class="text-gray-500">{{ $pick->confidence }}</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-600">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="mt-6 bg-slate-800 rounded-lg border border-slate-700 p-4">
                <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-3">Legend</h4>
                <div class="flex flex-wrap gap-6 text-sm">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500/30 text-red-400 text-xs font-medium mr-2">R</span>
                        <span class="text-gray-400">Picked Red Corner</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-500/30 text-blue-400 text-xs font-medium mr-2">B</span>
                        <span class="text-gray-400">Picked Blue Corner</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-700 ring-2 ring-green-500 mr-2"></span>
                        <span class="text-gray-400">Correct Pick</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-700 ring-2 ring-red-500 opacity-50 mr-2"></span>
                        <span class="text-gray-400">Wrong Pick</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-slate-800 rounded-lg border border-slate-700">
                <div class="px-6 py-4 border-b border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-200">Fight Results</h3>
                </div>
                <div class="divide-y divide-slate-700">
                    @foreach ($pool->event->fights->sortByDesc('bout_order') as $fight)
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    <span class="font-medium {{ $fight->winner === 'red' ? 'text-green-400' : 'text-gray-300' }}">
                                        {{ $fight->red_fighter }}
                                        @if ($fight->winner === 'red')
                                            <svg class="inline w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                    </span>
                                </div>
                                <div class="px-4 text-gray-500 text-sm">vs</div>
                                <div class="flex items-center flex-1 justify-end">
                                    <span class="font-medium {{ $fight->winner === 'blue' ? 'text-green-400' : 'text-gray-300' }}">
                                        @if ($fight->winner === 'blue')
                                            <svg class="inline w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        {{ $fight->blue_fighter }}
                                    </span>
                                    <span class="w-3 h-3 bg-blue-500 rounded-full ml-2"></span>
                                </div>
                            </div>
                            @if ($fight->winner)
                                <div class="text-center mt-2 text-sm text-gray-500">
                                    @if ($fight->winner === 'nc')
                                        No Contest
                                    @elseif ($fight->winner === 'draw')
                                        Draw
                                    @else
                                        {{ $fight->method }}@if($fight->round) (R{{ $fight->round }})@endif
                                    @endif
                                </div>
                            @else
                                <div class="text-center mt-2 text-sm text-yellow-500">Pending</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
