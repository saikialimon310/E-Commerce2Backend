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
        Schema::create('my_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('seller_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->text('delivery_address');
            $table->string('delivery_phone_no', 20);
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->string('payment_mode')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('order_confirmed_at')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_orders');
    }
};
