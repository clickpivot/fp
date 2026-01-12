<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">Enter Results</h2>
                <p class="text-sm text-gray-400 mt-1">{{ $event->name }}</p>
            </div>
            <a href="{{ route('admin.events.fights.index', $event) }}" class="text-gray-400 hover:text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Fights
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-800 rounded-lg border border-slate-700 p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div>
                        <h3 class="text-gray-200 font-medium">Scoring Information</h3>
                        <p class="text-gray-400 text-sm mt-1">When you save results, scores will automatically calculate for all players.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.events.results.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    @foreach ($fights as $fight)
                        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                            <div class="px-4 py-3 bg-slate-900/50 border-b border-slate-700 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400 font-medium">Bout #{{ $fight->bout_order }}</span>
                                    @if ($fight->is_main_event)
                                        <span class="bg-red-500/20 text-red-400 text-xs px-2 py-0.5 rounded">MAIN</span>
                                    @endif
                                    @if ($fight->is_co_main)
                                        <span class="bg-purple-500/20 text-purple-400 text-xs px-2 py-0.5 rounded">CO-MAIN</span>
                                    @endif
                                </div>
                                <span class="text-gray-500 text-sm">{{ $fight->weight_class }}</span>
                            </div>

                            <div class="p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                                        <span class="font-medium text-gray-200">{{ $fight->red_fighter }}</span>
                                    </div>
                                    <span class="text-gray-500">vs</span>
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-200">{{ $fight->blue_fighter }}</span>
                                        <span class="w-4 h-4 bg-blue-500 rounded-full ml-2"></span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Winner</label>
                                        <select name="results[{{ $fight->id }}][winner]" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Pending</option>
                                            <option value="red" {{ $fight->winner === 'red' ? 'selected' : '' }}>{{ $fight->red_fighter }} (Red)</option>
                                            <option value="blue" {{ $fight->winner === 'blue' ? 'selected' : '' }}>{{ $fight->blue_fighter }} (Blue)</option>
                                            <option value="draw" {{ $fight->winner === 'draw' ? 'selected' : '' }}>Draw</option>
                                            <option value="nc" {{ $fight->winner === 'nc' ? 'selected' : '' }}>No Contest</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Method</label>
                                        <select name="results[{{ $fight->id }}][method]" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Select Method</option>
                                            @foreach ($methods as $method)
                                                <option value="{{ $method }}" {{ $fight->method === $method ? 'selected' : '' }}>{{ $method }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1">Round</label>
                                        <select name="results[{{ $fight->id }}][round]" class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Select Round</option>
                                            @foreach ($rounds as $round)
                                                <option value="{{ $round }}" {{ (int)$fight->round === $round ? 'selected' : '' }}>Round {{ $round }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Save Results & Calculate Scores
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
