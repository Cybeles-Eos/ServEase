<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->string('nbi_clearance_path')->nullable()->after('barangay_clearance_path');
            $table->string('tesda_certificate_path')->nullable()->after('nbi_clearance_path');
            $table->string('recommendation_letter_path')->nullable()->after('tesda_certificate_path');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn([
                'nbi_clearance_path',
                'tesda_certificate_path',
                'recommendation_letter_path',
            ]);
        });
    }
};
