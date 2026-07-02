<?php

namespace App\Support;

use App\Models\User;

class AdminAuthorization
{
    public static function requireSuperAdmin(): void
    {
        if (! auth()->check() || ! auth()->user()->isSuperAdmin()) {
            abort(403);
        }
    }

    public static function canPermanentlyDeleteUser(User $target): bool
    {
        $actor = auth()->user();

        if (! $actor || ! $actor->isSuperAdmin()) {
            return false;
        }

        if ($actor->id === $target->id) {
            return false;
        }

        if ($target->isSuperAdmin()) {
            return false;
        }

        return in_array($target->role, ['provider', 'customer', 'admin'], true);
    }
}
