<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('gender');
        });

        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('gender');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });

        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });
    }
};
