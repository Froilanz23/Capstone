<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned(); // Links to orders table
            $table->bigInteger('user_id')->unsigned();  // Links to the customer or artist
            $table->enum('type', ['admin', 'artist', 'customer']); // Invoice type
            $table->decimal('amount', 10, 2); // Total invoice amount
            $table->string('status')->default('pending'); // Pending, Paid, etc.
            $table->date('issue_date')->nullable(); // Date invoice was issued
            $table->date('due_date')->nullable(); // Due date for payment
            $table->string('reference_number')->unique()->comment('Unique invoice reference number');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

