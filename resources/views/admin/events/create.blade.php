@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto px-4">
        <div class="mb-8">
            <a href="{{ route('admin.events.index') }}" class="text-orange-500 hover:text-orange-400">← Back</a>
            <h2 class="text-3xl font-bold text-slate-100 mt-4">Create Event</h2>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" class="bg-slate-800 rounded-2xl p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Event Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl px-4 py-3">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Start Date & Time *</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" required
                           class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl px-4 py-3">
                    @error('starts_at')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Status *</label>
                    <select name="status" required
                            class="w-full bg-slate-900 border border-slate-700 text-slate-100 rounded-xl px-4 py-3">
                        <option value="draft">Draft</option>
                        <option value="open">Open</option>
                        <option value="locked">Locked</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-400 text-slate-950 py-3 rounded-xl font-bold">
                        Create Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="flex-1 text-center bg-slate-700 hover:bg-slate-600 text-slate-100 py-3 rounded-xl font-bold">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
