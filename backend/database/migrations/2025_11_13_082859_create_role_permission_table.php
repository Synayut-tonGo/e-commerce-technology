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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id('role_permission_id')->primary();
            $table->foreignId('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            $table->foreignId('permission_id')->references('permission_id')->on('permissions')->onDelete('cascade');
            $table->foreignId('granted_by')->nullable()->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['role_id' , 'permission_id']); // prevent dupicate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
