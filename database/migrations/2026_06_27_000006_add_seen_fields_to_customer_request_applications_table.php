<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_request_applications', function (Blueprint $table) {
            $table->timestamp('customer_seen_at')->nullable()->after('accepted_at');
            $table->timestamp('provider_seen_at')->nullable()->after('customer_seen_at');
        });
    }

    public function down(): void
    {
        Schema::table('customer_request_applications', function (Blueprint $table) {
            $table->dropColumn(['customer_seen_at', 'provider_seen_at']);
        });
    }
};
