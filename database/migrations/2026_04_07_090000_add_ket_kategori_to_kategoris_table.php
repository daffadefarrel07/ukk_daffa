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
        if (Schema::hasTable('kategoris') && !Schema::hasColumn('kategoris', 'ket_kategori')) {
            Schema::table('kategoris', function (Blueprint $table) {
                $table->string('ket_kategori', 30)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('kategoris') && Schema::hasColumn('kategoris', 'ket_kategori')) {
            Schema::table('kategoris', function (Blueprint $table) {
                $table->dropColumn('ket_kategori');
            });
        }
    }
};
