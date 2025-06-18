<?php

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
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id'); // Explicit type
            $table->integer('quantity')->default(0);
            $table->string('unit')->default('pieces');
            $table->date('expiration_date')->nullable();
            $table->date('date_added')->default(now());
            $table->decimal('cost', 8, 2)->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['available', 'expired', 'low_stock'])->default('available');
            $table->timestamps();

            // Add foreign key constraint separately
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_items');
    }
};
