<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Fight;
use App\Models\Pick;
use App\Models\Play;
use App\Models\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Show form to enter fight results
     */
    public function edit(Event $event)
    {
        $fights = $event->fights()->orderBy('bout_order', 'asc')->get();

        $methods = [
            'KO/TKO',
            'Submission',
            'Decision (Unanimous)',
            'Decision (Split)',
            'Decision (Majority)',
            'DQ',
            'No Contest',
            'Draw',
        ];

        $rounds = [1, 2, 3, 4, 5];

        return view('admin.results.edit', compact('event', 'fights', 'methods', 'rounds'));
    }

    /**
     * Save fight results and calculate scores
     */
    public function update(Request $request, Event $event)
    {
        $fights = $event->fights;

        // Build validation rules
        $rules = [];
        foreach ($fights as $fight) {
            $rules["results.{$fight->id}.winner"] = 'nullable|in:red,blue,draw,nc';
            $rules["results.{$fight->id}.method"] = 'nullable|string|max:100';
            $rules["results.{$fight->id}.round"] = 'nullable|integer|min:1|max:5';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($event, $fights, $validated) {
            // Update fight results
            foreach ($fights as $fight) {
                $resultData = $validated['results'][$fight->id] ?? [];

                $fight->update([
                    'winner' => $resultData['winner'] ?? null,
                    'method' => $resultData['method'] ?? null,
                    'round' => $resultData['round'] ?? null,
                ]);
            }

            // Calculate scores for all pools associated with this event
            $this->calculateScores($event);
        });

        return redirect()->route('admin.events.results.edit', $event)
            ->with('success', 'Results saved and scores calculated.');
    }

    /**
     * Calculate scores for all picks in pools for this event
     */
    protected function calculateScores(Event $event)
    {
        // Get all pools for this event
        $pools = Pool::where('event_id', $event->id)->get();

        foreach ($pools as $pool) {
            // Get all plays in this pool
            $plays = Play::where('pool_id', $pool->id)->get();

            foreach ($plays as $play) {
                $totalPoints = 0;

                // Get all picks for this play
                $picks = Pick::where('play_id', $play->id)->get();

                foreach ($picks as $pick) {
                    // Get the fight
                    $fight = Fight::find($pick->fight_id);

                    if (!$fight || !$fight->winner) {
                        // Fight has no result yet, 0 points
                        $pick->update(['points_earned' => 0]);
                        continue;
                    }

                    // Handle no contest or draw - typically 0 points
                    if (in_array($fight->winner, ['nc', 'draw'])) {
                        $pick->update(['points_earned' => 0]);
                        continue;
                    }

                    // Check if pick is correct
                    if ($pick->selection === $fight->winner) {
                        // Correct pick: points = confidence value
                        $pointsEarned = $pick->confidence;
                    } else {
                        // Wrong pick: 0 points
                        $pointsEarned = 0;
                    }

                    $pick->update(['points_earned' => $pointsEarned]);
                    $totalPoints += $pointsEarned;
                }

                // Update play total
                $play->update(['total_points' => $totalPoints]);
            }
        }
    }
}
