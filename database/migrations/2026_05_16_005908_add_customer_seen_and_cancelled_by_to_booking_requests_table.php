<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->timestamp('customer_seen_at')->nullable()->after('provider_seen_at');
            $table->string('cancelled_by')->nullable()->after('customer_seen_at');
        });
    }

    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn(['customer_seen_at', 'cancelled_by']);
        });
    }
};
