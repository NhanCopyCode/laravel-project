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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('name')->nullable();
            $table->string('password');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('CCCD')->nullable();
            $table->string('driver_license')->nullable();
            $table->string('avatar')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();

            $table->bigInteger('role_id');
            $table->bigInteger('user_status_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
