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
        Schema::table('vehicles', function (Blueprint $table) {
            //
            $table->id('vehicle_id');
            $table->integer('CarRentalStore_id');
            $table->integer('model_id');
            $table->text('description');
            $table->string('license_plate', 50);
            $table->bigInteger('rental_price_day' );
            $table->integer('vehicle_status_id');
            $table->integer('vehicle_image_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            //
            
        });
    }
};
