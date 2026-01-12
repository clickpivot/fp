<?php

namespace App\Http\Controllers;

use App\Models\Play;
use App\Models\Pick;
use App\Models\Pool;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlayController extends Controller
{
    /**
     * Enhanced user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get user's active plays (upcoming events)
        $activePlays = Play::with(['pool.event', 'picks'])
            ->where('user_id', $user->id)
            ->whereHas('pool.event', function ($query) {
                $query->where('event_date', '>=', now());
            })
            ->get();

        // Get user's past plays (completed events)
        $pastPlays = Play::with(['pool.event', 'picks'])
            ->where('user_id', $user->id)
            ->whereHas('pool.event', function ($query) {
                $query->where('event_date', '<', now());
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get upcoming events (for joining new pools)
        $upcomingEvents = Event::with('pools')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();

        // Calculate user stats
        $totalPlays = Play::where('user_id', $user->id)->count();
        $totalPoints = Play::where('user_id', $user->id)->sum('total_points');

        // Calculate win count (plays where user ranked 1st)
        $wins = 0;
        $completedPlays = Play::with('pool.plays')
            ->where('user_id', $user->id)
            ->whereHas('pool.event', function ($query) {
                $query->where('event_date', '<', now());
            })
            ->get();

        foreach ($completedPlays as $play) {
            $maxPoints = $play->pool->plays->max('total_points');
            if ($play->total_points === $maxPoints && $maxPoints > 0) {
                $wins++;
            }
        }

        return view('dashboard', compact(
            'activePlays',
            'pastPlays',
            'upcomingEvents',
            'totalPlays',
            'totalPoints',
            'wins'
        ));
    }

    /**
     * Edit picks for a play
     */
    public function edit(Play $play)
    {
        // Ensure user owns this play
        if ($play->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit these picks.');
        }

        $play->load(['pool.event.fights' => function ($query) {
            $query->orderBy('bout_order', 'asc');
        }, 'picks']);

        // Check if event has started
        $eventStarted = $play->pool->event->event_date <= now();

        // Get existing picks indexed by fight_id
        $existingPicks = $play->picks->keyBy('fight_id');

        // Get fights
        $fights = $play->pool->event->fights;

        // Generate confidence options (1 to number of fights)
        $confidenceOptions = range(1, $fights->count());

        // Get used confidence values
        $usedConfidence = $existingPicks->pluck('confidence')->filter()->toArray();

        return view('plays.edit', compact(
            'play',
            'fights',
            'existingPicks',
            'confidenceOptions',
            'usedConfidence',
            'eventStarted'
        ));
    }

    /**
     * Update picks for a play
     */
    public function update(Request $request, Play $play)
    {
        // Ensure user owns this play
        if ($play->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to edit these picks.');
        }

        // Check if event has started
        if ($play->pool->event->event_date <= now()) {
            return back()->with('error', 'The event has already started. Picks are locked.');
        }

        $play->load('pool.event.fights');
        $fights = $play->pool->event->fights;

        // Validate request
        $rules = [];
        foreach ($fights as $fight) {
            $rules["picks.{$fight->id}.selection"] = 'required|in:red,blue';
            $rules["picks.{$fight->id}.confidence"] = 'required|integer|min:1|max:' . $fights->count();
        }

        $validated = $request->validate($rules, [
            'picks.*.selection.required' => 'Please select a fighter for each bout.',
            'picks.*.confidence.required' => 'Please assign confidence to each bout.',
        ]);

        // Check for duplicate confidence values
        $confidenceValues = collect($validated['picks'])->pluck('confidence');
        if ($confidenceValues->count() !== $confidenceValues->unique()->count()) {
            return back()
                ->withInput()
                ->with('error', 'Each bout must have a unique confidence value.');
        }

        // Update picks in a transaction
        DB::transaction(function () use ($play, $validated, $fights) {
            foreach ($fights as $fight) {
                $pickData = $validated['picks'][$fight->id];

                Pick::updateOrCreate(
                    [
                        'play_id' => $play->id,
                        'fight_id' => $fight->id,
                    ],
                    [
                        'selection' => $pickData['selection'],
                        'confidence' => $pickData['confidence'],
                        'points_earned' => 0, // Will be calculated when results are entered
                    ]
                );
            }
        });

        return redirect()->route('pools.show', $play->pool)
            ->with('success', 'Your picks have been saved!');
    }
}
