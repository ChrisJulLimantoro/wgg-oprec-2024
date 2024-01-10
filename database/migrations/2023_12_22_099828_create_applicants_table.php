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
            $table->text('experience')->nullable();

            $table->string('diet', 50);
            $table->string('allergy', 150)->nullable();
            $table->boolean('astor')->comment('0: tidak, 1: ya');

            $table->unsignedTinyInteger('stage')->default(2)->comment('1:udh isi Biodata, 2:udh isi Berkas, 3:udh Pilih Jadwal, 4:udh Interview & kerja Proyek');
            // $table->uuid('schedule_id')->nullable()->unique();
            $table->uuid('division_accepted')->nullable();
            $table->uuid('priority_division1');
            $table->uuid('priority_division2')->nullable();
            $table->unsignedTinyInteger('acceptance_stage')->default(1)->comment('1:tunggu-satu, 2:terima-satu, 3:tunggu-dua, 4:terima-dua, 5:tunggu-culik, 6:terima-culik');


            // $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('division_accepted')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('priority_division1')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('priority_division2')->references('id')->on('divisions')->onDelete('cascade');

            $table->json('documents')->nullable();
            $table->string('reschedule')->default("00")->comment("0: tidak revisi, 1: revisi, 2: sudah direvisi (digit pertama interview pilihan pertama, digit kedua interview pilihan kedua)");

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
