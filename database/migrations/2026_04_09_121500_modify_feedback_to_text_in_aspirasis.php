<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw statement to change column type to TEXT (safer without doctrine/dbal)
        DB::statement("ALTER TABLE `aspirasis` MODIFY `feedback` TEXT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // revert to integer
        DB::statement("ALTER TABLE `aspirasis` MODIFY `feedback` INT NULL;");
    }
};
