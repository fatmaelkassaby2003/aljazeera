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
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->morphs('serviceable'); // serviceable_type, serviceable_id
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('points')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });

        // Remove types column from services tables if they exist
        if (Schema::hasColumn('financial_services', 'types')) {
            Schema::table('financial_services', function (Blueprint $table) {
                $table->dropColumn('types');
            });
        }

        if (Schema::hasColumn('integration_services', 'types')) {
            Schema::table('integration_services', function (Blueprint $table) {
                $table->dropColumn('types');
            });
        }

        if (Schema::hasColumn('facility_services', 'types')) {
            Schema::table('facility_services', function (Blueprint $table) {
                $table->dropColumn('types');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_types');

        Schema::table('financial_services', function (Blueprint $table) {
            $table->json('types')->nullable();
        });

        Schema::table('integration_services', function (Blueprint $table) {
            $table->json('types')->nullable();
        });

        Schema::table('facility_services', function (Blueprint $table) {
            $table->json('types')->nullable();
        });
    }
};
