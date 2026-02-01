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
        Schema::create('tbl_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_num')->nullable();

            // Can be normalize further in the future (temporary only)
            $table->string('home_address')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();

            // Can be normalize further in the future (temporary only)
            $table->string('profession')->nullable();
            $table->integer('year_exp')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
