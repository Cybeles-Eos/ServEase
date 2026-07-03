<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_ratings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_request_id')
                ->constrained('booking_requests')
                ->cascadeOnDelete();

            $table->foreignId('booking_info_id')
                ->constrained('booking_infos')
                ->cascadeOnDelete();

            $table->foreignId('provider_id')
                ->constrained('tbl_providers')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->constrained('tbl_customers')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('tbl_services')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            $table->timestamps();

            $table->unique('booking_request_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_ratings');
    }
};
