<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')->constrained('program_studis')->cascadeOnDelete();
            $table->string('kode_mk')->unique();
            $table->string('nama_mk');
            $table->unsignedTinyInteger('sks');
            $table->boolean('status_aktif')->default(false);
            $table->timestamp('tanggal_dibuka')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
