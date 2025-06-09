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
        Schema::create('tb_mentor', function (Blueprint $table) {
            $table->id('id_mentor');
            $table->integer('id_users')->nullable();
            $table->integer('id_unit_kerja')->nullable();
            $table->string('nama_mentor')->nullable();
            $table->string('jabatan_mentor')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_mentor');
    }
};
