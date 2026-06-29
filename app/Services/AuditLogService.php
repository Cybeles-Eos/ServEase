<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuditLogService
{
    public static function record(
        string $module,
        string $event,
        string $description,
        ?Model $auditable = null,
        ?string $subjectLabel = null,
        array $metadata = []
    ): void {
        try {
            $user = Auth::user();
            $request = request();

            AuditLog::create([
                'actor_id' => $user?->id,
                'actor_name' => self::actorName($user),
                'actor_role' => $user?->role ?? 'system',
                'module' => $module,
                'event' => $event,
                'auditable_type' => $auditable ? $auditable::class : null,
                'auditable_id' => $auditable?->getKey(),
                'subject_label' => $subjectLabel,
                'description' => $description,
                'metadata' => empty($metadata) ? null : $metadata,
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ]);
        } catch (Throwable $exception) {
            Log::warning('Audit log write failed.', [
                'module' => $module,
                'event' => $event,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private static function actorName($user): string
    {
        if (! $user) {
            return 'System';
        }

        if ($user->isProvider() && $user->provider) {
            return trim(($user->provider->first_name ?? '') . ' ' . ($user->provider->last_name ?? '')) ?: ($user->name ?: $user->email);
        }

        if ($user->isCustomer() && $user->customer) {
            return trim(($user->customer->first_name ?? '') . ' ' . ($user->customer->last_name ?? '')) ?: ($user->name ?: $user->email);
        }

        return $user->name ?: $user->email ?: 'User #' . $user->id;
    }
}
