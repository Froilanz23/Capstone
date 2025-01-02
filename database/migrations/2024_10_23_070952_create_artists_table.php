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
        // Artists Table
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable()->comment('Profile image URL or path');
            $table->string('workplace_photo')->nullable()->comment('Photo in the workplace');
            $table->string('art_practice')->comment('Artist category or practice');
            $table->string('email')->nullable()->comment('Contact email');
            $table->string('mobile')->nullable();
            $table->text('address')->nullable()->comment('Full address of the artist');

            $table->text('artist_description')->nullable();
            $table->string('portfolio_url')->nullable()->comment('Portfolio URL');
            $table->string('valid_id')->comment('Valid ID document URL or path');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
