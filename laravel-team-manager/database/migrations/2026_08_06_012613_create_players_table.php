<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('abbr');
            $table->timestamps();
        });

        Schema::create('players', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('team_id')->index()->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('state_id')->index()->constrained();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('states');
    }
};
