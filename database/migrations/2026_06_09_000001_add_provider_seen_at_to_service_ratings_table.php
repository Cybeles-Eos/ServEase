<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_ratings', function (Blueprint $table) {
            $table->timestamp('provider_seen_at')
                ->nullable()
                ->after('is_visible');
        });
    }

    public function down(): void
    {
        Schema::table('service_ratings', function (Blueprint $table) {
            $table->dropColumn('provider_seen_at');
        });
    }
};
