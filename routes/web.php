<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\PickController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PoolController as AdminPoolController;
use App\Http\Controllers\Admin\FightController as AdminFightController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// PUBLIC POOL ROUTES (authenticated users)
// ============================================
Route::middleware(['auth'])->group(function () {
    // Browse all pools
    Route::get('/pools', [PoolController::class, 'index'])->name('pools.index');
    
    // View single pool details
    Route::get('/pools/{pool}', [PoolController::class, 'show'])->name('pools.show');
    
    // Join a pool (creates a Play)
    Route::post('/pools/{pool}/join', [PoolController::class, 'join'])->name('pools.join');
    
    // Pool leaderboard
    Route::get('/pools/{pool}/leaderboard', [PoolController::class, 'leaderboard'])->name('pools.leaderboard');
    
    // Edit picks for a play
    Route::get('/plays/{play}/edit', [PlayController::class, 'edit'])->name('plays.edit');
    Route::put('/plays/{play}', [PlayController::class, 'update'])->name('plays.update');
    
    // User dashboard (enhanced)
    Route::get('/dashboard', [PlayController::class, 'dashboard'])->name('dashboard');
});

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Events CRUD (existing)
    Route::resource('events', AdminEventController::class);
    
    // Pools CRUD (existing index, add full CRUD)
    Route::resource('pools', AdminPoolController::class);
    
    // Fights CRUD (nested under events)
    Route::get('/events/{event}/fights', [AdminFightController::class, 'index'])->name('events.fights.index');
    Route::get('/events/{event}/fights/create', [AdminFightController::class, 'create'])->name('events.fights.create');
    Route::post('/events/{event}/fights', [AdminFightController::class, 'store'])->name('events.fights.store');
    Route::get('/events/{event}/fights/{fight}/edit', [AdminFightController::class, 'edit'])->name('events.fights.edit');
    Route::put('/events/{event}/fights/{fight}', [AdminFightController::class, 'update'])->name('events.fights.update');
    Route::delete('/events/{event}/fights/{fight}', [AdminFightController::class, 'destroy'])->name('events.fights.destroy');
    
    // Results entry
    Route::get('/events/{event}/results', [AdminResultController::class, 'edit'])->name('events.results.edit');
    Route::put('/events/{event}/results', [AdminResultController::class, 'update'])->name('events.results.update');
});

require __DIR__.'/auth.php';
