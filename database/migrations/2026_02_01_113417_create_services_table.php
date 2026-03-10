<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_id')->unique()->nullable();

            // Relationship
            $table->foreignId('provider_id')
                  ->constrained('tbl_providers')
                  ->cascadeOnDelete();

            // Main Service Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('specialization')->nullable();

            // Pricing
            $table->decimal('price', 10, 2)->nullable();

            // Image (store file path only)
            $table->string('image')->nullable();

            // Stats
            // $table->unsignedInteger('jobs')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            // $table->unsignedInteger('reviews')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_services');
    }
};
