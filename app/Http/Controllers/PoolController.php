<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Play;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoolController extends Controller
{
    /**
     * Display all public pools
     */
    public function index()
    {
        $pools = Pool::with(['event'])
            ->withCount('plays')
            ->whereHas('event', function ($query) {
                $query->where('starts_at', '>=', now()->subDays(1));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pools.index', compact('pools'));
    }

    /**
     * Display a single pool with fights
     */
    public function show(Pool $pool)
    {
        $pool->load(['event.fights' => function ($query) {
            $query->orderBy('bout_order', 'asc');
        }, 'plays.user']);

        $userPlay = null;
        if (Auth::check()) {
            $userPlay = $pool->plays()->where('user_id', Auth::id())->first();
        }

        $hasJoined = $userPlay !== null;
        $eventStarted = $pool->event->starts_at && $pool->event->starts_at <= now();

        return view('pools.show', compact('pool', 'userPlay', 'hasJoined', 'eventStarted'));
    }

    /**
     * Join a pool (create a Play entry)
     */
    public function join(Pool $pool)
    {
        $user = Auth::user();

        // Check if already joined
        $existingPlay = Play::where('pool_id', $pool->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingPlay) {
            return redirect()->route('plays.edit', $existingPlay)
                ->with('info', 'You have already joined this pool.');
        }

        // Check if event has started
        if ($pool->event->starts_at && $pool->event->starts_at <= now()) {
            return back()->with('error', 'This event has already started. You cannot join.');
        }

        // Create the play
        $play = Play::create([
            'pool_id' => $pool->id,
            'user_id' => $user->id,
            'total_score' => 0,
        ]);

        return redirect()->route('plays.edit', $play)
            ->with('success', 'You have joined the pool! Now make your picks.');
    }

    /**
     * Display pool leaderboard
     */
    public function leaderboard(Pool $pool)
    {
        $pool->load(['event.fights' => function ($query) {
            $query->orderBy('bout_order', 'asc');
        }]);

        // Get all plays with picks, ordered by total points
        $plays = $pool->plays()
            ->with(['user', 'picks.fight'])
            ->orderBy('total_score', 'desc')
            ->get();

        // Calculate rankings (handle ties)
        $rank = 0;
        $lastPoints = null;
        $sameRankCount = 0;

        foreach ($plays as $play) {
            if ($play->total_score !== $lastPoints) {
                $rank += $sameRankCount + 1;
                $sameRankCount = 0;
            } else {
                $sameRankCount++;
            }

            $play->rank = $rank;
            $lastPoints = $play->total_score;
        }

        $eventCompleted = $pool->event->fights->every(function ($fight) {
            return $fight->winner !== null;
        });

        return view('pools.leaderboard', compact('pool', 'plays', 'eventCompleted'));
    }
}
