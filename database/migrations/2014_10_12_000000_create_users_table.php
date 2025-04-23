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
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_superuser')->default(false);
            $table->timestamp('last_login')->nullable();
            $table->enum('role', ['ADS', 'PRESIDENT', 'MEMBER']);
            $table->boolean('is_verified')->default(false);
            $table->string('phone_number');
            $table->date('dob');
            $table->text('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
