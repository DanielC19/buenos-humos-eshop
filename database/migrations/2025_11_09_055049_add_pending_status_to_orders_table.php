<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the enum column to include the new 'pending' status
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'validating', 'confirmed', 'cancelled') NOT NULL DEFAULT 'validating'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('validating', 'confirmed', 'cancelled') NOT NULL DEFAULT 'validating'");
    }
};
