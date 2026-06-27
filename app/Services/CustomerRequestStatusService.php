<?php

namespace App\Services;

use App\Models\CustomerRequest;
use Illuminate\Support\Facades\Log;

class CustomerRequestStatusService
{
    public function autoCompleteAcceptedRequests(): int
    {
        $completed = CustomerRequest::query()
            ->where('status', 'accepted')
            ->whereNotNull('accepted_at')
            ->where('accepted_at', '<=', now()->subHours(24))
            ->update([
                'status' => 'completed',
                'completed_at' => now(),
                'completion_source' => 'auto',
                'updated_at' => now(),
            ]);

        Log::info('Customer request auto-complete finished', [
            'completed' => $completed,
        ]);

        return $completed;
    }
}
