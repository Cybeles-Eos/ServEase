<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_requests', function (Blueprint $table) {
            $table->date('preferred_date')->nullable()->after('fixed_price');
            $table->time('preferred_time')->nullable()->after('preferred_date');
        });
    }

    public function down(): void
    {
        Schema::table('customer_requests', function (Blueprint $table) {
            $table->dropColumn(['preferred_date', 'preferred_time']);
        });
    }
};
