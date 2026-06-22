<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('phone_number');
        });

        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('phone_number');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_customers', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('tbl_providers', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
