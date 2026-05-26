<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->string('resume_path')->nullable()->after('year_exp');

            // For later implementation.
            $table->string('barangay_clearance_path')->nullable()->after('resume_path');

            $table->string('application_status')->default('pending')->after('barangay_clearance_path');
            $table->timestamp('application_reviewed_at')->nullable()->after('application_status');
            $table->unsignedBigInteger('application_reviewed_by')->nullable()->after('application_reviewed_at');
            $table->text('application_remarks')->nullable()->after('application_reviewed_by');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn([
                'resume_path',
                'barangay_clearance_path',
                'application_status',
                'application_reviewed_at',
                'application_reviewed_by',
                'application_remarks',
            ]);
        });
    }
};