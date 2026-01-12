<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    Edit Fight
                </h2>
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-lg border border-slate-700 p-6">
                <form action="{{ route('admin.events.fights.update', [$event, $fight]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Red Corner --}}
                        <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                            <div class="flex items-center mb-4">
                                <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                                <h3 class="text-lg font-semibold text-red-400">Red Corner</h3>
                            </div>

                            <div class="mb-4">
                                <label for="red_fighter" class="block text-sm font-medium text-gray-300 mb-1">Fighter Name *</label>
                                <input type="text" name="red_fighter" id="red_fighter" value="{{ old('red_fighter', $fight->red_fighter) }}"
                                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                    required>
                                @error('red_fighter')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="red_odds" class="block text-sm font-medium text-gray-300 mb-1">Odds</label>
                                <input type="text" name="red_odds" id="red_odds" value="{{ old('red_odds', $fight->red_odds) }}" placeholder="-150"
                                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                @error('red_odds')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Blue Corner --}}
                        <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4">
                            <div class="flex items-center mb-4">
                                <span class="w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                                <h3 class="text-lg font-semibold text-blue-400">Blue Corner</h3>
                            </div>

                            <div class="mb-4">
                                <label for="blue_fighter" class="block text-sm font-medium text-gray-300 mb-1">Fighter Name *</label>
                                <input type="text" name="blue_fighter" id="blue_fighter" value="{{ old('blue_fighter', $fight->blue_fighter) }}"
                                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                    required>
                                @error('blue_fighter')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="blue_odds" class="block text-sm font-medium text-gray-300 mb-1">Odds</label>
                                <input type="text" name="blue_odds" id="blue_odds" value="{{ old('blue_odds', $fight->blue_odds) }}" placeholder="+130"
                                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500">
                                @error('blue_odds')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Fight Details --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="weight_class" class="block text-sm font-medium text-gray-300 mb-1">Weight Class *</label>
                            <select name="weight_class" id="weight_class"
                                class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                required>
                                <option value="">Select Weight Class</option>
                                @foreach ($weightClasses as $class)
                                    <option value="{{ $class }}" {{ old('weight_class', $fight->weight_class) === $class ? 'selected' : '' }}>
                                        {{ $class }}
                                    </option>
                                @endforeach
                            </select>
                            @error('weight_class')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bout_order" class="block text-sm font-medium text-gray-300 mb-1">Bout Order *</label>
                            <input type="number" name="bout_order" id="bout_order" value="{{ old('bout_order', $fight->bout_order) }}" min="1"
                                class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-gray-200 focus:ring-orange-500 focus:border-orange-500"
                                required>
                            <p class="text-xs text-gray-500 mt-1">Higher = later on card (main event highest)</p>
                            @error('bout_order')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Flags --}}
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-300 mb-3">Fight Flags</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_main_event" value="1" {{ old('is_main_event', $fight->is_main_event) ? 'checked' : '' }}
                                    class="w-4 h-4 bg-slate-700 border-slate-600 rounded text-red-500 focus:ring-red-500">
                                <span class="ml-2 text-gray-300">Main Event</span>
                            </label>

                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_co_main" value="1" {{ old('is_co_main', $fight->is_co_main) ? 'checked' : '' }}
                                    class="w-4 h-4 bg-slate-700 border-slate-600 rounded text-purple-500 focus:ring-purple-500">
                                <span class="ml-2 text-gray-300">Co-Main Event</span>
                            </label>

                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_swimmies" value="1" {{ old('is_swimmies', $fight->is_swimmies) ? 'checked' : '' }}
                                    class="w-4 h-4 bg-slate-700 border-slate-600 rounded text-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-gray-300">Swimmies</span>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex items-center justify-between">
                        <form action="{{ route('admin.events.fights.destroy', [$event, $fight]) }}" method="POST" onsubmit="return confirm('Delete this fight?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">
                                Delete Fight
                            </button>
                        </form>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.events.fights.index', $event) }}" class="text-gray-400 hover:text-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                                Update Fight
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
