<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->json('resubmission_required_documents')->nullable()->after('application_remarks');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn('resubmission_required_documents');
        });
    }
};
