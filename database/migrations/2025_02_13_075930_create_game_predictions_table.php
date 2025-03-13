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
        Schema::create('game_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->integer('home_goals');
            $table->integer('away_goals');
            $table->integer('home_penalty_goals')->default(0)->nullable();
            $table->integer('away_penalty_goals')->default(0)->nullable();
            $table->integer('points')->default(0);
            $table->timestamps();
						$table->softDeletes();

						$table->unique(['user_id', 'game_id', 'deleted_at'], 'game_predictions_unique_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
			Schema::table('game_predictions', function (Blueprint $table) {
				$table->dropUnique('game_predictions_unique_combination');
			});
        Schema::dropIfExists('game_predictions');
    }
};
