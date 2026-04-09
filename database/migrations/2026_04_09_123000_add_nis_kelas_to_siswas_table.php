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
        if (Schema::hasTable('siswas')) {
            Schema::table('siswas', function (Blueprint $table) {
                if (! Schema::hasColumn('siswas', 'nis')) {
                    $table->string('nis', 20)->unique()->nullable()->after('id');
                }
                if (! Schema::hasColumn('siswas', 'kelas')) {
                    $table->string('kelas', 20)->nullable()->after('nis');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('siswas')) {
            Schema::table('siswas', function (Blueprint $table) {
                if (Schema::hasColumn('siswas', 'kelas')) {
                    $table->dropColumn('kelas');
                }
                if (Schema::hasColumn('siswas', 'nis')) {
                    $table->dropUnique(['nis']);
                    $table->dropColumn('nis');
                }
            });
        }
    }
};
