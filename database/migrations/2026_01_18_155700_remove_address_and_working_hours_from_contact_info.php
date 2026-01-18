<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_info', function (Blueprint $table) {
            $table->dropColumn(['address', 'working_hours']);
        });
    }

    public function down(): void
    {
        Schema::table('contact_info', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('working_hours')->nullable();
        });
    }
};
