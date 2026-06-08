<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('facebook_page')->nullable();
            $table->text('office_address')->nullable();
            $table->string('support_hours')->nullable();
            $table->string('platform_name')->nullable();
            $table->string('platform_tagline')->nullable();
            $table->string('service_area')->nullable();
            $table->string('privacy_policy_url')->nullable();
            $table->string('terms_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
