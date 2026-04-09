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
                if (! Schema::hasColumn('aspirasis', 'status')) {
                    $table->enum('status', ['Menunggu', 'Proses', 'Selesai'])->default('Menunggu');
                }

                if (! Schema::hasColumn('aspirasis', 'feedback')) {
                    $table->integer('feedback')->nullable();
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
                if (Schema::hasColumn('aspirasis', 'feedback')) {
                    $table->dropColumn('feedback');
                }
                if (Schema::hasColumn('aspirasis', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
