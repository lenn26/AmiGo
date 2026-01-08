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
        Schema::create('UNIVERSITIES', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('type', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('NOTIFICATIONS', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('message');
            $table->boolean('is_read')->default(0);
            $table->foreignId('user_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('LOGS_ADMIN', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->foreignId('target_user_id')->nullable()->constrained('USERS')->onDelete('set null');
            $table->foreignId('admin_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('TRIPS', function (Blueprint $table) {
            $table->id();
            $table->string('start_address');
            $table->decimal('start_lat', 10, 6);
            $table->decimal('start_long', 10, 6);
            $table->string('end_address');
            $table->decimal('end_lat', 10, 6);
            $table->decimal('end_long', 10, 6);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('distance_km', 10, 1)->nullable();
            $table->string('description', 500)->nullable();
            $table->decimal('price', 10, 2);
            $table->string('status', 20)->default('planned');
            $table->boolean('girl_only')->default(0);
            $table->boolean('accepts_pets')->default(0);
            $table->boolean('accepts_luggage')->default(1);
            $table->integer('seats_available');
            $table->foreignId('driver_id')->constrained('USERS')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('VEHICLES');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('TRIP_STOPS', function (Blueprint $table) {
            $table->id();
            $table->string('stop_address');
            $table->integer('stop_order');
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->dateTime('arrival_time')->nullable();
            $table->foreignId('trip_id')->constrained('TRIPS')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('BOOKINGS', function (Blueprint $table) {
            $table->id();
            $table->integer('seats_booked')->default(1);
            $table->string('status', 20)->default('pending');
            $table->foreignId('passenger_id')->constrained('USERS')->onDelete('cascade');
            $table->foreignId('trip_id')->constrained('TRIPS')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('MESSAGES', function (Blueprint $table) {
            $table->id();
            $table->string('content', 1000);
            $table->boolean('is_read')->default(0);
            $table->foreignId('trip_id')->nullable()->constrained('TRIPS')->onDelete('set null');
            $table->foreignId('from_user_id')->constrained('USERS')->onDelete('cascade');
            $table->foreignId('to_user_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('RATINGS', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->string('comment', 500)->nullable();
            $table->foreignId('trip_id')->constrained('TRIPS')->onDelete('cascade');
            $table->foreignId('rated_id')->constrained('USERS')->onDelete('cascade');
            $table->foreignId('rater_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('REPORTS', function (Blueprint $table) {
            $table->id();
            $table->string('reason', 100);
            $table->string('description', 1000)->nullable();
            $table->string('status', 20)->default('open');
            $table->foreignId('trip_id')->nullable()->constrained('TRIPS')->onDelete('set null');
            $table->foreignId('reported_user_id')->constrained('USERS')->onDelete('cascade');
            $table->foreignId('reporter_id')->constrained('USERS')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('REPORTS');
        Schema::dropIfExists('RATINGS');
        Schema::dropIfExists('MESSAGES');
        Schema::dropIfExists('BOOKINGS');
        Schema::dropIfExists('TRIP_STOPS');
        Schema::dropIfExists('TRIPS');
        Schema::dropIfExists('LOGS_ADMIN');
        Schema::dropIfExists('NOTIFICATIONS');
        Schema::dropIfExists('UNIVERSITIES');
    }
};
