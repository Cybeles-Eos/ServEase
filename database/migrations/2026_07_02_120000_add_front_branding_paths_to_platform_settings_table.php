<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('platform_settings', function (Blueprint $table) {
            $table->string('front_logo_path')->nullable()->after('terms_url');
            $table->string('front_footer_logo_path')->nullable()->after('front_logo_path');
            $table->string('front_favicon_path')->nullable()->after('front_footer_logo_path');
            $table->string('meta_image_path')->nullable()->after('front_favicon_path');
        });
    }

    public function down(): void
    {
        Schema::table('platform_settings', function (Blueprint $table) {
            $table->dropColumn([
                'front_logo_path',
                'front_footer_logo_path',
                'front_favicon_path',
                'meta_image_path',
            ]);
        });
    }
};
