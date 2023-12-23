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
        Schema::create('schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('admin_id')->nullable(false);
            $table->uuid('date_id')->nullable(false);

            $table->integer('time');
            $table->integer('status')->default(1)->comment('0: not available, 1: available, 2: booked');
            $table->unique(array('admin_id', 'date_id', 'time'));


            $table->timestamps();
            $table->softDeletes();

            $table->foreign('date_id')->references('id')->on('dates')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
