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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');

            $table->string('image')->nullable()->comment('Main product image');
            $table->text('images')->nullable()->comment('Additional product images');

            $table->unsignedBigInteger('category_id')->nullable()->comment('Product category ID');
            $table->unsignedBigInteger('artist_id')->nullable()->comment('Artist ID');
            $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade')->comment('FK to artists table');
            
            $table->decimal('regular_price', 10, 2)->comment('Regular price of the product');
            $table->unsignedInteger('quantity')->default(1)->comment('Default quantity is 1 as artwork is unique');
            $table->unsignedInteger('year_created')->comment('Year the artwork was created');
            $table->string('dimensions')->nullable()->comment('Dimensions of the product (e.g., LxWxH)');

            $table->boolean('featured')->default(false)->comment('If true, product is featured');
            $table->boolean('COA')->default(false)->comment('Certificate of Authenticity included');
            $table->boolean('framed')->default(false)->comment('If true, product is framed');
            $table->boolean('signature')->default(false)->comment('If true, product has the artist\'s signature');
            
            $table->boolean('is_sold')->default(false)->comment('If true, product is sold');
        
            $table->enum('subject', [
                'Animals and Plants',
                'Dreams and Fantasies',
                'Everyday Life',
                'Faith and Mythology',
                'Figures and Patterns',
                'History and Legend',
                'Land Sea and Cityscapes',
                'Portraits',
                'Still Life',
                'Others'
            ])->comment('Subject of the artwork');
    
            $table->enum('medium', [
                'Acrylic',
                'Charcoal',
                'Coffee',
                'Digital',
                'Oil',
                'Watercolor',
                'Graphite',
                'Ink',
                'Marker',
                'Mixed Media',
                'Enamel',
                'Pastel',
                'Gouache',
                'Others'
            ])->comment('Medium used in the artwork');
    
            $table->enum('style', [
                '3D Art',
                'Abstract',
                'Abstract Expressionism',
                'Art Deco',
                'Avant-garde',
                'Classicism',
                'Conceptual',
                'Contemporary',
                'Constructivism',
                'Cubism',
                'Dada',
                'Documentary',
                'Expressionism',
                'Fauvism',
                'Figurative',
                'Fine Art',
                'Folk',
                'Futurism',
                'Illustration',
                'Impressionism',
                'Installation Art',
                'Minimalism',
                'Photorealism',
                'Pointillism',
                'Pop Art',
                'Portraiture',
                'Realism',
                'Street Art',
                'Surrealism',
                'Others'
            ])->comment('Art style of the artwork');

            $table->enum('material', [
                'Board',
                'Bronze',
                'Canvas',
                'Cardboard',
                'Glass',
                'Panel',
                'Paper',
                'Soft (Fabrics)',
                'Special Paper',
                'Wood',
                'Fabric',
                'Fine Art Paper',
                'Others'
            ])->comment('Material used in the artwork');

            $table->timestamps();
            $table->softDeletes()->comment('Soft delete column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
