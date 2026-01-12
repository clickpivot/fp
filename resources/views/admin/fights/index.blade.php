<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    Manage Fights
                </h2>
                <p class="text-sm text-gray-400 mt-1">{{ $event->name }}</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Events
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <div class="text-gray-400">
                    {{ $fights->count() }} fight(s) on this card
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.events.results.edit', $event) }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Enter Results
                    </a>
                    <a href="{{ route('admin.events.fights.create', $event) }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add Fight
                    </a>
                </div>
            </div>

            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                @if ($fights->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-400 mb-4">No fights added to this event yet.</p>
                        <a href="{{ route('admin.events.fights.create', $event) }}" class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Add First Fight
                        </a>
                    </div>
                @else
                    <table class="w-full">
                        <thead class="bg-slate-900/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Red Corner</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">vs</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Blue Corner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Weight Class</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Flags</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Result</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach ($fights as $fight)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-400 font-medium">{{ $fight->bout_order }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                            <span class="text-gray-200 {{ $fight->winner === 'red' ? 'text-green-400 font-medium' : '' }}">
                                                {{ $fight->red_fighter }}
                                            </span>
                                        </div>
                                        @if ($fight->red_odds)
                                            <span class="text-xs text-gray-500 ml-5">{{ $fight->red_odds }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500">vs</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                            <span class="text-gray-200 {{ $fight->winner === 'blue' ? 'text-green-400 font-medium' : '' }}">
                                                {{ $fight->blue_fighter }}
                                            </span>
                                        </div>
                                        @if ($fight->blue_odds)
                                            <span class="text-xs text-gray-500 ml-5">{{ $fight->blue_odds }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                        {{ $fight->weight_class }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-1">
                                            @if ($fight->is_main_event)
                                                <span class="bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded">ME</span>
                                            @endif
                                            @if ($fight->is_co_main)
                                                <span class="bg-purple-500/20 text-purple-400 text-xs px-2 py-0.5 rounded">CO</span>
                                            @endif
                                            @if ($fight->is_swimmies)
                                                <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-0.5 rounded">SW</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($fight->winner)
                                            <span class="text-sm text-green-400">
                                                @if ($fight->winner === 'red')
                                                    {{ $fight->red_fighter }}
                                                @elseif ($fight->winner === 'blue')
                                                    {{ $fight->blue_fighter }}
                                                @elseif ($fight->winner === 'nc')
                                                    NC
                                                @else
                                                    Draw
                                                @endif
                                            </span>
                                            @if ($fight->method)
                                                <span class="text-xs text-gray-500 block">{{ $fight->method }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-500 text-sm">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.events.fights.edit', [$event, $fight]) }}" class="text-gray-400 hover:text-orange-400 transition-colors">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.events.fights.destroy', [$event, $fight]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this fight?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
