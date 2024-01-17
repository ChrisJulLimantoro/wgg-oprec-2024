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
        Schema::create('majors', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('english_name');
            $table->string('code');
            $table->uuid('faculty_id');

            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
