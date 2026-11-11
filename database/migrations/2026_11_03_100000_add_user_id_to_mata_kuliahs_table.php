<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()
                ->after('program_studi_id')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
