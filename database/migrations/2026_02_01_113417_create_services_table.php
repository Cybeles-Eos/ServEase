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
        Schema::create('tbl_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('tbl_providers')->cascadeOnDelete();

            // Major details
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->string('specialization');

            // Minor details
            $table->unsignedInteger('jobs')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_services');
    }
};
