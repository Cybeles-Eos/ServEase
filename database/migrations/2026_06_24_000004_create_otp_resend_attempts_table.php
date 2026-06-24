<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_resend_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('device_key', 64);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('window_started_at')->nullable();
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();

            $table->unique(['email', 'device_key']);
            $table->index('locked_until');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_resend_attempts');
    }
};
