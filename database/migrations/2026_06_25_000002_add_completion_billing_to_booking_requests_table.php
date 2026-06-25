<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->unsignedInteger('completed_hours')->nullable()->after('cancelled_by');
            $table->unsignedTinyInteger('completed_minutes')->nullable()->after('completed_hours');
            $table->decimal('completed_total', 10, 2)->nullable()->after('completed_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn([
                'completed_hours',
                'completed_minutes',
                'completed_total',
            ]);
        });
    }
};
