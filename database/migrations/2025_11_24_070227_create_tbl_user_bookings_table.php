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
        Schema::create('tbl_user_bookings', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->uuid('user_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->date('booking_date');
            $table->enum('booking_type', ['full_day', 'half_day', 'custom']);
            $table->enum('booking_slot', ['first_half', 'second_half'])->nullable();
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_bookings');
    }
};
