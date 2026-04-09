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
        if (Schema::hasTable('input_aspirasis')) {
            Schema::table('input_aspirasis', function (Blueprint $table) {
                if (! Schema::hasColumn('input_aspirasis', 'lokasi')) {
                    $table->string('lokasi', 255)->nullable();
                }
                if (! Schema::hasColumn('input_aspirasis', 'ket')) {
                    $table->text('ket')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('input_aspirasis')) {
            Schema::table('input_aspirasis', function (Blueprint $table) {
                if (Schema::hasColumn('input_aspirasis', 'ket')) {
                    $table->dropColumn('ket');
                }
                if (Schema::hasColumn('input_aspirasis', 'lokasi')) {
                    $table->dropColumn('lokasi');
                }
            });
        }
    }
};
