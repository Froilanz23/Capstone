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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();

            // Financial Details
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);

            // Customer Information
            $table->string('name');
            $table->string('phone');
            $table->string('house_number')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');

            // Shipping Details
            $table->enum('shipping_option', ['pickup', 'shipping'])->default('shipping');
            $table->string('tracking_number')->nullable();
            $table->string('shipping_company')->nullable();
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->boolean('is_shipping_different')->nullable();
            $table->enum('status', ['pending', 'ordered', 'shipped', 'delivered', 'canceled'])->default('pending');

            // Dates
            $table->date('shipped_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('canceled_date')->nullable();

            // Soft Deletes and Timestamps
            $table->softDeletes(); // Adds the deleted_at column for soft deletes
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
