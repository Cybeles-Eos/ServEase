<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_deleted_records', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->string('provider_email');
            $table->timestamp('deleted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_deleted_records');
    }
};
