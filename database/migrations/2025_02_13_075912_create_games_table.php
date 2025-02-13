<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('away_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('groups')->cascadeOnDelete();
            $table->enum('game_type', ['GROUP', 'ROUND OF 32', 'ROUND OF 16', 'QUARTER FINAL', 'SEMI FINAL', 'LOOSERS FINAL', 'FINAL']);
            $table->dateTime('date');
            $table->string('stadium');
            $table->integer('home_goals')->default(0);
            $table->integer('away_goals')->default(0);
            $table->integer('home_penalty_goals')->default(0);
            $table->integer('away_penalty_goals')->default(0);
            $table->boolean('is_knockout')->default(false);
            $table->boolean('is_winner_bonus')->default(false);
            $table->boolean('is_score_bonus')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
