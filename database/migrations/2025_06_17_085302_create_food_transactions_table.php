<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_item_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['added', 'consumed', 'expired', 'wasted']);
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_transactions');
    }
};