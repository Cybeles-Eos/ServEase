<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'fullname')) {
                $table->string('fullname')->after('id');
            }

            if (!Schema::hasColumn('contacts', 'email')) {
                $table->string('email')->after('fullname');
            }

            if (!Schema::hasColumn('contacts', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('contacts', 'subject')) {
                $table->string('subject')->after('phone');
            }

            if (!Schema::hasColumn('contacts', 'message')) {
                $table->text('message')->nullable()->after('subject');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'message')) {
                $table->dropColumn('message');
            }

            if (Schema::hasColumn('contacts', 'subject')) {
                $table->dropColumn('subject');
            }

            if (Schema::hasColumn('contacts', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('contacts', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('contacts', 'fullname')) {
                $table->dropColumn('fullname');
            }
        });
    }
};