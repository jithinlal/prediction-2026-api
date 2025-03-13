<?php

use App\Enums\StatTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stat_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->enum('type',  [
							StatTypeEnum::GOAL->value,
							StatTypeEnum::YELLOW_CARD->value,
							StatTypeEnum::RED_CARD->value,
							StatTypeEnum::CLEAN_SHEET->value,
						]);
            $table->integer('points')->default(0);
            $table->timestamps();
						$table->softDeletes();

						$table->unique(['user_id', 'game_id', 'player_id', 'type'], 'stat_predictions_unique_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
				Schema::table('stat_predictions', function (Blueprint $table) {
					$table->dropUnique('stat_predictions_unique_combination');
				});
        Schema::dropIfExists('stat_predictions');
    }
};
