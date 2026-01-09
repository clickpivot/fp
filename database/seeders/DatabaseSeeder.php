<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Fight;
use App\Models\Pool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fightpool.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create test users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Sarah Smith',
            'email' => 'sarah@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create sample event
        $event = Event::create([
            'name' => 'UFC 310: Championship Night',
            'slug' => 'ufc-310-championship-night',
            'starts_at' => now()->addDays(7),
            'status' => 'open',
        ]);

        // Create sample fights
        Fight::create([
            'event_id' => $event->id,
            'bout_order' => 1,
            'fighter_red' => 'Jon Jones',
            'fighter_blue' => 'Stipe Miocic',
            'weight_class' => 'Heavyweight',
            'odds_red' => -350,
            'odds_blue' => +280,
            'is_main_event' => true,
            'swimmies_allowed' => true,
        ]);

        Fight::create([
            'event_id' => $event->id,
            'bout_order' => 2,
            'fighter_red' => 'Alexandre Pantoja',
            'fighter_blue' => 'Brandon Moreno',
            'weight_class' => 'Flyweight',
            'odds_red' => -180,
            'odds_blue' => +155,
            'is_co_main_event' => true,
        ]);

        Fight::create([
            'event_id' => $event->id,
            'bout_order' => 3,
            'fighter_red' => 'Sean Strickland',
            'fighter_blue' => 'Dricus Du Plessis',
            'weight_class' => 'Middleweight',
            'odds_red' => +120,
            'odds_blue' => -140,
        ]);

        // Create sample pool
        Pool::create([
            'event_id' => $event->id,
            'name' => 'UFC 310 Main Pool',
            'slug' => 'ufc-310-main-pool',
            'visibility' => 'public',
            'entry_fee_cents' => 0,
            'locks_at' => $event->starts_at,
        ]);
    }
}
