<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('tbl_customers')
                ->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('fixed_price', 10, 2);
            $table->string('image_path')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->text('contact_address')->nullable();
            $table->string('status', 20)->default('open');
            $table->foreignId('accepted_provider_id')
                ->nullable()
                ->constrained('tbl_providers')
                ->nullOnDelete();
            $table->unsignedBigInteger('accepted_application_id')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('completion_source', 20)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['customer_id', 'status']);
            $table->index(['accepted_provider_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_requests');
    }
};
