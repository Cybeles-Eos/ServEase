<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_request_id')->constrained('booking_requests')->cascadeOnDelete();
            $table->foreignId('booking_info_id')->constrained('booking_infos')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('tbl_customers')->cascadeOnDelete();
            $table->foreignId('provider_id')->constrained('tbl_providers')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('tbl_services')->cascadeOnDelete();
            $table->string('reason', 120);
            $table->text('details')->nullable();
            $table->string('status', 30)->default('OPEN');
            $table->timestamps();

            $table->unique('booking_request_id');
            $table->index(['provider_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
