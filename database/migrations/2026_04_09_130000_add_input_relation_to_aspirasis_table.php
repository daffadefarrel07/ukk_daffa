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
                if (! Schema::hasColumn('aspirasis', 'input_pelaporan_id')) {
                    $table->unsignedBigInteger('input_pelaporan_id')->nullable();
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
                if (Schema::hasColumn('aspirasis', 'input_pelaporan_id')) {
                    $table->dropForeign(['input_pelaporan_id']);
                    $table->dropColumn('input_pelaporan_id');
                }
            });
        }
    }
};
