<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        if (User::query()->where('role', 'super_admin')->exists()) {
            return;
        }

        User::query()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
            'password' => Hash::make('test123'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }

    public function down(): void
    {
        User::query()
            ->where('email', 'superadmin@example.com')
            ->where('role', 'super_admin')
            ->forceDelete();
    }
};
