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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id('role_user_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade');
            //constrained = references('user_id')->on('users') it gonna go to find foreignID for us
            //if your primary key on other table not match your foreign key = contrained('roles'this is table , your primary key column)
            // you can use this constrained() when on other table have default id
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['user_id' , 'role_id']); // prevent the user add duplicate role_user ex: Yut - admin cannot add this one more
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
