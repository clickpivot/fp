<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('picks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fight_id')->constrained()->cascadeOnDelete();
            $table->enum('selection', ['red', 'blue']);
            $table->integer('confidence');
            $table->boolean('swimmies_used')->default(false);
            $table->decimal('points_earned', 10, 2)->nullable();
            $table->timestamps();
            
            $table->unique(['play_id', 'fight_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('picks');
    }
};
