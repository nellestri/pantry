php artisan make:migrat<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->decimal('quantity', 10, 2); // Changed to decimal for better precision
            $table->string('unit');
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('original_quantity', 10, 2)->default(0); // Track original amount
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_items');
    }
};