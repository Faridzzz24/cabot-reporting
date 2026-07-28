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
        DB::statement("ALTER TABLE audit_logs MODIFY COLUMN action ENUM('viewed','status_changed','assigned','commented','exported','rca_generated','rca_saved') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe down migration: keep the new values, as rollback would fail if data exists
    }
};
