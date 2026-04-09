<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Siswas table - add nis, kelas, user_id
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nis', 20);
            $table->string('kelas', 10)->default('-');
            $table->foreignId('user_id')->nullable()->constrained('users');
        });

        // Kategoris table - add nama
        Schema::table('kategoris', function (Blueprint $table) {
            $table->string('nama');
        });

        // InputAspirasis table - add all columns
        Schema::table('input_aspirasis', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->foreignId('siswa_id')->constrained('siswas');
            $table->string('lokasi', 255);
            $table->text('ket')->nullable();
        });

        // Aspirasis table - add columns
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->foreignId('input_pelaporan_id')->constrained('input_aspirasis');
            $table->string('status', 20)->default('Menunggu');
            $table->text('feedback')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('aspirasis', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['input_pelaporan_id']);
            $table->dropColumn(['kategori_id', 'input_pelaporan_id', 'status', 'feedback']);
        });
        
        Schema::table('input_aspirasis', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['kategori_id', 'siswa_id', 'lokasi', 'ket']);
        });
        
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropColumn('nama');
        });
        
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['nis', 'kelas', 'user_id']);
        });
    }
};

