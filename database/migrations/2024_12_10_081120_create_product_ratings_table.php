<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Links to the products table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Links to the users table
            $table->tinyInteger('rating')->unsigned()->comment('Rating value between 1-5'); // Rating value
            $table->text('review')->nullable(); // Optional review text
            $table->string('verification_status')->default('pending'); // Removed ->after('review')
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_ratings');
    }
};
