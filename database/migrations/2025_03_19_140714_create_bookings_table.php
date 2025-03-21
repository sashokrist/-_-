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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('business_id');
            $table->dateTime('date_time');

            $table->string('client_name');
            $table->string('personal_id');

            $table->text('description')->nullable();

            $table->enum('notification_method', ['SMS', 'Email']);

            $table->timestamps();

            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('hairstylist_id')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();

            $table->index('user_id', 'fk_bookings_user');
            $table->index('business_id', 'fk_bookings_business');
            $table->index('doctor_id', 'bookings_doctor_id_foreign');
            $table->index('hairstylist_id', 'fk_bookings_hairstylist');
            $table->index('table_id', 'fk_bookings_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
