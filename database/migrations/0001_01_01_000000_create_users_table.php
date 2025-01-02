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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->date('birthdate')->nullable();
            $table->string('password');

            // Define roles as tiny integers: 1 = Admin, 2 = Artist, 3 = Customer (default)
            $table->tinyInteger('role')->default(3)->comment('1 = Admin, 2 = Artist, 3 = Customer');

            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_blocked')->default(false)->comment('User blocked status');
            // $table->boolean('verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Password Reset Tokens Table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Sessions Table for User Activity Tracking
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};