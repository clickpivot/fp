<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->integer('bout_order');
            $table->string('fighter_red');
            $table->string('fighter_blue');
            $table->string('weight_class');
            $table->integer('odds_red');
            $table->integer('odds_blue');
            $table->boolean('is_main_event')->default(false);
            $table->boolean('is_co_main_event')->default(false);
            $table->boolean('swimmies_allowed')->default(false);
            $table->enum('winner', ['red', 'blue', 'draw', 'no_contest'])->nullable();
            $table->string('method')->nullable();
            $table->integer('ending_round')->nullable();
            $table->string('ending_time')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
            $table->string('api_external_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fights');
    }
};
