<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_otps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('email');
            $table->string('otp');

            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_otps');
    }
};