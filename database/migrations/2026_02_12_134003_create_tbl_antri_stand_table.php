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
        Schema::create('tbl_antri_stand', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->date('tanggal_pesan');
            $table->char('kd_stand', 2);
            $table->integer('nomor_antri');
            $table->timestamps();

            $table->foreign('kd_stand')
                    ->references('kd_stand')
                    ->on('tbl_quota_stand')
                    ->onDelete('cascade');
            
            $table->unique(['email', 'kd_stand', 'tanggal_pesan'], 'pengaturan_antrian_harian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_antri_stand');
    }
};
