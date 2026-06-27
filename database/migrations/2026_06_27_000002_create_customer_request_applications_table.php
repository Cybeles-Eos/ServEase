<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_request_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_request_id')
                ->constrained('customer_requests')
                ->cascadeOnDelete();
            $table->foreignId('provider_id')
                ->constrained('tbl_providers')
                ->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->unique(['customer_request_id', 'provider_id'], 'customer_request_provider_unique');
            $table->index(['provider_id', 'status']);
        });

        Schema::table('customer_requests', function (Blueprint $table) {
            $table->foreign('accepted_application_id')
                ->references('id')
                ->on('customer_request_applications')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('customer_requests', function (Blueprint $table) {
            $table->dropForeign(['accepted_application_id']);
        });

        Schema::dropIfExists('customer_request_applications');
    }
};
