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
       Schema::create('input_aspirasis', function (Blueprint $table) {
    $table->id('id_pelaporan');

    $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
    $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');

    $table->string('lokasi', 50);
    $table->string('ket', 50);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_aspirasis');
    }
};
