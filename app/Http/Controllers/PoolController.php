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
        $pools = Pool::with(['event', 'plays'])
            ->whereHas('event', function ($query) {
                $query->where('event_date', '>=', now()->subDays(1));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Group pools by upcoming vs past
        $upcomingPools = $pools->filter(function ($pool) {
            return $pool->event->event_date >= now();
        });

        $pastPools = $pools->filter(function ($pool) {
            return $pool->event->event_date < now();
        });

        return view('pools.index', compact('upcomingPools', 'pastPools'));
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
        $eventStarted = $pool->event->event_date <= now();

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
        if ($pool->event->event_date <= now()) {
            return back()->with('error', 'This event has already started. You cannot join.');
        }

        // Create the play
        $play = Play::create([
            'pool_id' => $pool->id,
            'user_id' => $user->id,
            'total_points' => 0,
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
            ->orderBy('total_points', 'desc')
            ->get();

        // Calculate rankings (handle ties)
        $rank = 0;
        $lastPoints = null;
        $sameRankCount = 0;

        foreach ($plays as $play) {
            if ($play->total_points !== $lastPoints) {
                $rank += $sameRankCount + 1;
                $sameRankCount = 0;
            } else {
                $sameRankCount++;
            }
            $play->rank = $rank;
            $lastPoints = $play->total_points;
        }

        $eventCompleted = $pool->event->fights->every(function ($fight) {
            return $fight->winner !== null;
        });

        return view('pools.leaderboard', compact('pool', 'plays', 'eventCompleted'));
    }
}
