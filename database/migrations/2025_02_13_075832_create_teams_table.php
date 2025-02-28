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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->string('continent');
            $table->string('image');
            $table->integer('rank');
            $table->integer('world_cups')->default(0);
            $table->string('manager_name');
						$table->boolean('is_eliminated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
