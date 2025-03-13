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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->string('image');
            $table->boolean('is_star')->default(false);
            $table->enum('position', ['GK', 'DEF', 'MID', 'FWD']);
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->boolean('is_injured')->default(false);
            $table->timestamps();
						$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
