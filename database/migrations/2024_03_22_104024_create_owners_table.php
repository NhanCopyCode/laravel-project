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
        Schema::create('owners', function (Blueprint $table) {
            $table->increments('owner_id');
            $table->string('company_name', 255)->nullable();
            $table->string('tax_code', 255)->nullable();
            $table->string('business_license', 255)->nullable();
            $table->string('description', 255)->nullable();

            $table->foreign('user_id')->references('owner_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
