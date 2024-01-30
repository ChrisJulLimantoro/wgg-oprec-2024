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
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 50)->unique()->nullable(false);
            $table->string('name', 80)->nullable(false);
            $table->string('line', 20)->nullable(false);
            $table->string('meet')->nullable();
            $table->string('spot')->nullable();
            $table->uuid('division_id')->nullable();
            $table->json('medical_history')->nullable();


            $table->foreign('division_id')->references('id')->on('divisions');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
