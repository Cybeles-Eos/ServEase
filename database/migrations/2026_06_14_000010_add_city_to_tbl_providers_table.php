<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tbl_providers', 'city')) {
            Schema::table('tbl_providers', function (Blueprint $table) {
                $table->string('city')->nullable()->after('home_address');
            });
        }

        if (Schema::hasColumn('tbl_providers', 'province')) {
            DB::table('tbl_providers')
                ->whereNull('city')
                ->update(['city' => DB::raw('province')]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tbl_providers', 'city')) {
            Schema::table('tbl_providers', function (Blueprint $table) {
                $table->dropColumn('city');
            });
        }
    }
};
