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
        Schema::create('tb_kegiatan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->integer('id_peserta')->nullable();
            $table->date('tanggal_mulai_kegiatan')->nullable();
            $table->date('tanggal_selesai_kegiatan')->nullable();
            $table->text('deskripsi_kegiatan')->nullable();
            $table->integer('progres_kegiatan')->nullable();
            $table->text('keterangan_kegiatan')->nullable();
            $table->enum('status_kegiatan', ['draft', 'submitted', 'validated', 'rejected'])->default('draft');
            $table->text('catatan_pembimbing')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kegiatan');
    }
};
