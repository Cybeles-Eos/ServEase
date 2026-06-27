<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->string('valid_id_path')->nullable()->after('profile_image');
            $table->string('verification_status')->default('not_submitted')->after('valid_id_path');
            $table->timestamp('verification_submitted_at')->nullable()->after('verification_status');
            $table->timestamp('verification_reviewed_at')->nullable()->after('verification_submitted_at');
            $table->foreignId('verification_reviewed_by')->nullable()->after('verification_reviewed_at')->constrained('users')->nullOnDelete();
            $table->text('verification_declined_reason')->nullable()->after('verification_reviewed_by');
            $table->timestamp('verification_seen_at')->nullable()->after('verification_declined_reason');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verification_reviewed_by');
            $table->dropColumn([
                'valid_id_path',
                'verification_status',
                'verification_submitted_at',
                'verification_reviewed_at',
                'verification_declined_reason',
                'verification_seen_at',
            ]);
        });
    }
};
