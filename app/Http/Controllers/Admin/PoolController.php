<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use Illuminate\View\View;

class PoolController extends Controller
{
    public function index(): View
    {
        $pools = Pool::query()
            ->with('event')
            ->withCount('plays')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.pools.index', compact('pools'));
    }
}
