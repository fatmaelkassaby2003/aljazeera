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
        Schema::table('quote_requests', function (Blueprint $table) {
            // Add budget_range_id foreign key
            $table->foreignId('budget_range_id')
                  ->nullable()
                  ->after('budget_range')
                  ->constrained('budget_ranges')
                  ->nullOnDelete();
            
            // Keep old budget_range column for now (will remove after data migration)
            // $table->dropColumn('budget_range');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropForeign(['budget_range_id']);
            $table->dropColumn('budget_range_id');
        });
    }
};
