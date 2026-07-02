<?php

namespace App\Services;

use App\Models\BookingRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserPermanentDeleteService
{
    private const ACTIVE_BOOKING_STATUSES = ['PENDING', 'ACCEPTED', 'ONGOING'];

    public function delete(User $user): void
    {
        if ($this->hasActiveBookings($user)) {
            throw ValidationException::withMessages([
                'user' => ['This account cannot be permanently deleted while it has active bookings.'],
            ]);
        }

        if ($user->isSuperAdmin() && User::query()->where('role', 'super_admin')->count() <= 1) {
            throw ValidationException::withMessages([
                'user' => ['The last Super Admin account cannot be permanently deleted.'],
            ]);
        }

        DB::transaction(function () use ($user) {
            $this->deleteStoredFiles($user);
            $user->forceDelete();
        });
    }

    public function hasActiveBookings(User $user): bool
    {
        if ($user->role === 'provider') {
            $user->loadMissing('provider');

            if (! $user->provider) {
                return false;
            }

            return BookingRequest::query()
                ->where('provider_id', $user->provider->id)
                ->whereIn('status', self::ACTIVE_BOOKING_STATUSES)
                ->exists();
        }

        if ($user->role === 'customer') {
            $user->loadMissing('customer');

            if (! $user->customer) {
                return false;
            }

            return BookingRequest::query()
                ->whereHas('bookingInfo', function ($query) use ($user) {
                    $query->where('customer_id', $user->customer->id);
                })
                ->whereIn('status', self::ACTIVE_BOOKING_STATUSES)
                ->exists();
        }

        return false;
    }

    private function deleteStoredFiles(User $user): void
    {
        $user->loadMissing(['provider', 'customer']);

        if ($user->provider) {
            foreach ([
                $user->provider->resume_path,
                $user->provider->barangay_clearance_path,
                $user->provider->nbi_clearance_path,
                $user->provider->tesda_certificate_path,
                $user->provider->recommendation_letter_path,
                $user->provider->profile_image,
            ] as $path) {
                $this->deletePublicFile($path);
            }
        }

        if ($user->customer) {
            foreach ([
                $user->customer->valid_id_path,
                $user->customer->profile_image,
            ] as $path) {
                $this->deletePublicFile($path);
            }
        }
    }

    private function deletePublicFile(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $storagePath = str_starts_with($path, 'public/')
            ? substr($path, 7)
            : $path;

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }
}
