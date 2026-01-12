<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    Make Your Picks
                </h2>
                <p class="text-sm text-gray-400 mt-1">{{ $play->pool->name }} &bull; {{ $play->pool->event->name }}</p>
            </div>
            <a href="{{ route('pools.show', $play->pool) }}" class="text-gray-400 hover:text-gray-300 flex items-center">
                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Pool
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

            @if (session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($eventStarted)
                <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    The event has started. Picks are locked and cannot be changed.
                </div>
            @endif

            <div class="bg-slate-800 rounded-lg border border-slate-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-200 mb-2">How Scoring Works</h3>
                <p class="text-gray-400 text-sm">
                    Select a winner for each fight (Red or Blue corner) and assign a confidence value.
                    Higher confidence = more potential points. Each bout must have a unique confidence value.
                    If your pick is correct, you earn points equal to your confidence value.
                </p>
            </div>

            <form action="{{ route('plays.update', $play) }}" method="POST" id="picks-form">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    @foreach ($fights->sortByDesc('bout_order') as $fight)
                        @php
                            $existingPick = $existingPicks->get($fight->id);
                            $currentSelection = old("picks.{$fight->id}.selection", $existingPick?->selection);
                            $currentConfidence = old("picks.{$fight->id}.confidence", $existingPick?->confidence);
                        @endphp

                        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden fight-card" data-fight-id="{{ $fight->id }}">
                            <div class="px-4 py-2 bg-slate-900/50 border-b border-slate-700 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if ($fight->is_main_event)
                                        <span class="bg-red-500/20 text-red-400 text-xs font-medium px-2 py-0.5 rounded">MAIN EVENT</span>
                                    @endif
                                    @if ($fight->is_co_main)
                                        <span class="bg-purple-500/20 text-purple-400 text-xs font-medium px-2 py-0.5 rounded">CO-MAIN</span>
                                    @endif
                                    @if ($fight->is_swimmies)
                                        <span class="bg-blue-500/20 text-blue-400 text-xs font-medium px-2 py-0.5 rounded">SWIMMIES</span>
                                    @endif
                                    <span class="text-gray-500 text-sm">{{ $fight->weight_class }}</span>
                                </div>
                                <span class="text-gray-500 text-sm">Bout #{{ $fight->bout_order }}</span>
                            </div>

                            <div class="p-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    {{-- Red Corner --}}
                                    <label class="cursor-pointer {{ $eventStarted ? 'pointer-events-none opacity-75' : '' }}">
                                        <input type="radio"
                                               name="picks[{{ $fight->id }}][selection]"
                                               value="red"
                                               class="hidden fighter-selection"
                                               data-fight-id="{{ $fight->id }}"
                                               {{ $currentSelection === 'red' ? 'checked' : '' }}
                                               {{ $eventStarted ? 'disabled' : '' }}>
                                        <div class="fighter-card red-corner p-4 rounded-lg border-2 transition-all
                                            {{ $currentSelection === 'red' ? 'border-red-500 bg-red-500/20' : 'border-slate-600 hover:border-red-500/50' }}">
                                            <div class="flex items-center mb-2">
                                                <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                                                <span class="text-xs text-red-400 font-medium uppercase">Red Corner</span>
                                            </div>
                                            <div class="font-semibold text-gray-200 text-lg">{{ $fight->red_fighter }}</div>
                                            @if ($fight->red_odds)
                                                <div class="text-sm text-gray-500 mt-1">{{ $fight->red_odds }}</div>
                                            @endif
                                        </div>
                                    </label>

                                    {{-- Confidence Selector --}}
                                    <div class="text-center">
                                        <label class="block text-sm text-gray-400 mb-2">Confidence</label>
                                        <select name="picks[{{ $fight->id }}][confidence]"
                                                class="confidence-select bg-slate-700 border border-slate-600 text-gray-200 rounded-lg px-4 py-2 w-24 text-center focus:ring-orange-500 focus:border-orange-500"
                                                data-fight-id="{{ $fight->id }}"
                                                {{ $eventStarted ? 'disabled' : '' }}>
                                            <option value="">-</option>
                                            @foreach ($confidenceOptions as $conf)
                                                <option value="{{ $conf }}" {{ (int)$currentConfidence === $conf ? 'selected' : '' }}>
                                                    {{ $conf }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="text-xs text-gray-500 mt-1">pts if correct</div>
                                    </div>

                                    {{-- Blue Corner --}}
                                    <label class="cursor-pointer {{ $eventStarted ? 'pointer-events-none opacity-75' : '' }}">
                                        <input type="radio"
                                               name="picks[{{ $fight->id }}][selection]"
                                               value="blue"
                                               class="hidden fighter-selection"
                                               data-fight-id="{{ $fight->id }}"
                                               {{ $currentSelection === 'blue' ? 'checked' : '' }}
                                               {{ $eventStarted ? 'disabled' : '' }}>
                                        <div class="fighter-card blue-corner p-4 rounded-lg border-2 transition-all
                                            {{ $currentSelection === 'blue' ? 'border-blue-500 bg-blue-500/20' : 'border-slate-600 hover:border-blue-500/50' }}">
                                            <div class="flex items-center justify-end mb-2">
                                                <span class="text-xs text-blue-400 font-medium uppercase">Blue Corner</span>
                                                <span class="w-4 h-4 bg-blue-500 rounded-full ml-2"></span>
                                            </div>
                                            <div class="font-semibold text-gray-200 text-lg text-right">{{ $fight->blue_fighter }}</div>
                                            @if ($fight->blue_odds)
                                                <div class="text-sm text-gray-500 mt-1 text-right">{{ $fight->blue_odds }}</div>
                                            @endif
                                        </div>
                                    </label>
                                </div>

                                @error("picks.{$fight->id}.selection")
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @error("picks.{$fight->id}.confidence")
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (!$eventStarted)
                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('pools.show', $play->pool) }}" class="text-gray-400 hover:text-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-8 rounded-lg transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Save Picks
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle fighter selection visual feedback
            document.querySelectorAll('.fighter-selection').forEach(radio => {
                radio.addEventListener('change', function() {
                    const fightId = this.dataset.fightId;
                    const card = document.querySelector(`.fight-card[data-fight-id="${fightId}"]`);

                    // Reset both corners
                    card.querySelectorAll('.fighter-card').forEach(fc => {
                        fc.classList.remove('border-red-500', 'bg-red-500/20', 'border-blue-500', 'bg-blue-500/20');
                        fc.classList.add('border-slate-600');
                    });

                    // Highlight selected
                    const selectedCard = this.closest('label').querySelector('.fighter-card');
                    selectedCard.classList.remove('border-slate-600');
                    if (this.value === 'red') {
                        selectedCard.classList.add('border-red-500', 'bg-red-500/20');
                    } else {
                        selectedCard.classList.add('border-blue-500', 'bg-blue-500/20');
                    }
                });
            });

            // Handle confidence selection validation
            document.querySelectorAll('.confidence-select').forEach(select => {
                select.addEventListener('change', function() {
                    validateConfidence();
                });
            });

            function validateConfidence() {
                const selects = document.querySelectorAll('.confidence-select');
                const usedValues = [];

                selects.forEach(select => {
                    if (select.value) {
                        usedValues.push(select.value);
                    }
                });

                // Check for duplicates
                const hasDuplicates = usedValues.length !== new Set(usedValues).size;

                selects.forEach(select => {
                    if (hasDuplicates && usedValues.filter(v => v === select.value).length > 1) {
                        select.classList.add('border-red-500');
                    } else {
                        select.classList.remove('border-red-500');
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
