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
        if (Schema::hasTable('aspirasis')) {
            Schema::table('aspirasis', function (Blueprint $table) {
                if (! Schema::hasColumn('aspirasis', 'kategori_id')) {
                    $table->unsignedBigInteger('kategori_id')->nullable()->after('input_pelaporan_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('aspirasis')) {
            Schema::table('aspirasis', function (Blueprint $table) {
                if (Schema::hasColumn('aspirasis', 'kategori_id')) {
                    $table->dropColumn('kategori_id');
                }
            });
        }
    }
};
