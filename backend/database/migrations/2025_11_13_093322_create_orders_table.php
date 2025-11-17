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
            $table->id('order_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->enum('order_type',['normal','preorder'])->default('normal');
            $table->enum('status' , ['pending' , 'paid' , 'shipped' , 'completed' , 'cancelled'])->default('pending');
            $table->decimal('total_amount', 7, 2)->default(0);
            $table->timestamps();
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
