<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Fight;
use Illuminate\Http\Request;

class FightController extends Controller
{
    /**
     * Display fights for an event
     */
    public function index(Event $event)
    {
        $fights = $event->fights()->orderBy('bout_order', 'asc')->get();

        return view('admin.fights.index', compact('event', 'fights'));
    }

    /**
     * Show form to create a fight
     */
    public function create(Event $event)
    {
        $weightClasses = [
            'Strawweight',
            'Flyweight',
            'Bantamweight',
            'Featherweight',
            'Lightweight',
            'Welterweight',
            'Middleweight',
            'Light Heavyweight',
            'Heavyweight',
            "Women's Strawweight",
            "Women's Flyweight",
            "Women's Bantamweight",
            "Women's Featherweight",
            'Catchweight',
        ];

        // Get next bout order
        $nextBoutOrder = $event->fights()->max('bout_order') + 1;

        return view('admin.fights.create', compact('event', 'weightClasses', 'nextBoutOrder'));
    }

    /**
     * Store a new fight
     */
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'red_fighter' => 'required|string|max:255',
            'blue_fighter' => 'required|string|max:255',
            'weight_class' => 'required|string|max:100',
            'red_odds' => 'nullable|string|max:20',
            'blue_odds' => 'nullable|string|max:20',
            'bout_order' => 'required|integer|min:1',
            'is_main_event' => 'boolean',
            'is_co_main' => 'boolean',
            'is_swimmies' => 'boolean',
        ]);

        $validated['event_id'] = $event->id;
        $validated['is_main_event'] = $request->has('is_main_event');
        $validated['is_co_main'] = $request->has('is_co_main');
        $validated['is_swimmies'] = $request->has('is_swimmies');

        Fight::create($validated);

        return redirect()->route('admin.events.fights.index', $event)
            ->with('success', 'Fight created successfully.');
    }

    /**
     * Show form to edit a fight
     */
    public function edit(Event $event, Fight $fight)
    {
        $weightClasses = [
            'Strawweight',
            'Flyweight',
            'Bantamweight',
            'Featherweight',
            'Lightweight',
            'Welterweight',
            'Middleweight',
            'Light Heavyweight',
            'Heavyweight',
            "Women's Strawweight",
            "Women's Flyweight",
            "Women's Bantamweight",
            "Women's Featherweight",
            'Catchweight',
        ];

        return view('admin.fights.edit', compact('event', 'fight', 'weightClasses'));
    }

    /**
     * Update a fight
     */
    public function update(Request $request, Event $event, Fight $fight)
    {
        $validated = $request->validate([
            'red_fighter' => 'required|string|max:255',
            'blue_fighter' => 'required|string|max:255',
            'weight_class' => 'required|string|max:100',
            'red_odds' => 'nullable|string|max:20',
            'blue_odds' => 'nullable|string|max:20',
            'bout_order' => 'required|integer|min:1',
            'is_main_event' => 'boolean',
            'is_co_main' => 'boolean',
            'is_swimmies' => 'boolean',
        ]);

        $validated['is_main_event'] = $request->has('is_main_event');
        $validated['is_co_main'] = $request->has('is_co_main');
        $validated['is_swimmies'] = $request->has('is_swimmies');

        $fight->update($validated);

        return redirect()->route('admin.events.fights.index', $event)
            ->with('success', 'Fight updated successfully.');
    }

    /**
     * Delete a fight
     */
    public function destroy(Event $event, Fight $fight)
    {
        $fight->delete();

        return redirect()->route('admin.events.fights.index', $event)
            ->with('success', 'Fight deleted successfully.');
    }
}
