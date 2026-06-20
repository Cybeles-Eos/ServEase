<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->join('tbl_providers', 'tbl_providers.user_id', '=', 'users.id')
            ->where('users.role', 'provider')
            ->where('tbl_providers.application_status', 'declined')
            ->update(['users.is_active' => 0]);
    }

    public function down(): void
    {
        //
    }
};
