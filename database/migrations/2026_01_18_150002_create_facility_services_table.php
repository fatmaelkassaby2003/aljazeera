<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facility_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('إدارة المرافق');
            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('important_note')->nullable();
            $table->json('types')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_services');
    }
};
