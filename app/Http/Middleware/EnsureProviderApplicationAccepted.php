<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProviderApplicationAccepted
{
    public function handle(Request $request, Closure $next)
    {
        $provider = auth()->user()?->provider;

        if (! $provider) {
            abort(403, 'Provider account not found.');
        }

        if ($provider->application_status === 'declined') {
            return redirect()->route(
                !empty($provider->resubmission_required_documents)
                    ? 'provider.resubmit'
                    : 'provider.declined'
            );
        }

        if ($provider->application_status !== 'accepted') {
            abort(403, 'Provider application is not yet accepted.');
        }

        return $next($request);
    }
}
