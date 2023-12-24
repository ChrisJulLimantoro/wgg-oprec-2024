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
        Schema::create('applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 50)->unique();
            $table->string('name', 100);
            $table->boolean('gender')->comment('0: male, 1: female');
            $table->string('religion', 30);
            $table->string('birthplace', 50)->comment('kota kelahiran');
            $table->date('birthdate');

            $table->string('province', 50);
            $table->string('city', 50);
            $table->text('address');
            $table->string('postal_code', 5);
            $table->string('phone', 15);
            $table->string('line', 50)->nullable();
            $table->string('instagram', 50)->nullable();
            $table->string('tiktok', 50)->nullable();
            
            $table->string('gpa', 4)->comment('IPK');
            $table->text('motivation');
            $table->text('commitment');
            $table->text('strength');
            $table->text('weakness');
            $table->text('experience');

            $table->string('diet', 50);
            $table->string('allergy', 150)->nullable();
            
            $table->boolean('astor')->comment('0: tidak, 1: ya');
            $table->foreignUuid('priority_division1')->constrained(table: 'divisions');
            $table->foreignUuid('priority_division2')->constrained(table: 'divisions')->nullable();
            $table->foreignUuid('division_accepted')->constrained(table: 'divisions')->nullable();
         
            $table->json('documents')->nullable();
            $table->foreignUuid('schedule_id')->nullable()->constrained(table: 'schedules');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
