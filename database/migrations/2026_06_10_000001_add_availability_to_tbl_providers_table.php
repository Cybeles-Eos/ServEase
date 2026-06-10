<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->json('availability_days')->nullable()->after('year_exp');
            $table->time('availability_start_time')->nullable()->after('availability_days');
            $table->time('availability_end_time')->nullable()->after('availability_start_time');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn([
                'availability_days',
                'availability_start_time',
                'availability_end_time',
            ]);
        });
    }
};
