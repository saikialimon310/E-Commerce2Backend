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
        Schema::create('available_products', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Quantities
            $table->integer('available_quantity')->default(0);
            $table->integer('booked_quantity')->default(0);
            $table->integer('total_sell_quantity')->default(0);

            // Timestamps
            $table->timestamps();

            // Soft Delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_products');
    }
};