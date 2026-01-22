<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integration_services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('خدمات تكامل الأنظمة');
            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('important_note')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('integration_services');
    }
};
