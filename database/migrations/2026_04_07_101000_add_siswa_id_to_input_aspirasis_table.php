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
        if (Schema::hasTable('input_aspirasis') && ! Schema::hasColumn('input_aspirasis', 'siswa_id')) {
            Schema::table('input_aspirasis', function (Blueprint $table) {
                $table->foreignId('siswa_id')->nullable()->constrained('siswas')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('input_aspirasis') && Schema::hasColumn('input_aspirasis', 'siswa_id')) {
            Schema::table('input_aspirasis', function (Blueprint $table) {
                $table->dropForeign(['siswa_id']);
                $table->dropColumn('siswa_id');
            });
        }
    }
};
