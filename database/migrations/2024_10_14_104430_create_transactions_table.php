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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->unsignedBigInteger('payment_method_id')->nullable(); // For tracking payment methods
            $table->enum('mode', ['bank', 'gcash', 'other'])->default('other'); // Enhanced for flexibility
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->string('receipt')->nullable();
            $table->string('transaction_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
    
            // Ensure referenced tables exist
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (Schema::hasTable('orders')) {
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            }
            if (Schema::hasTable('payment_methods')) {
                $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Remove the `deleted_at` column
        });
    }
};