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
        Schema::create('VEHICLES', function (Blueprint $table) {
            $table->id();
            $table->string('make', 50);
            $table->string('model', 50);
            $table->string('color', 30)->nullable();
            $table->string('license_plate', 20);
            $table->integer('seats_total');
            $table->foreignId('owner_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VEHICLES');
    }
};
