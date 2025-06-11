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
        Schema::create('tb_peserta', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->integer('id_user')->nullable();
            $table->integer('id_unit_kerja')->nullable();
            $table->integer('id_mentor')->nullable();
            $table->string('nama_peserta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_peserta');
    }
};