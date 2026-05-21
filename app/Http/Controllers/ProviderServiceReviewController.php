<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRating;
use Illuminate\Http\Request;

class ProviderServiceReviewController extends Controller
{
    public function index($serviceId)
    {
        $provider = auth()->user()->provider;

        if (!$provider) {
            abort(403);
        }

        $service = Service::with([
                'provider',
                'serviceCategory',
                'ratings',
                'ratings.customer',
                'ratings.customer.user',
            ])
            ->where('id', $serviceId)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        $ratings = $service->ratings()
            ->with(['customer', 'customer.user'])
            ->latest()
            ->paginate(8);

        $averageRating = round($service->ratings()->avg('rating') ?? 0, 1);
        $ratingCount = $service->ratings()->count();
        $visibleCount = $service->ratings()->where('is_visible', true)->count();
        $hiddenCount = $service->ratings()->where('is_visible', false)->count();

        return view('admin.page.provider.service-reviews', [
            'service' => $service,
            'ratings' => $ratings,
            'averageRating' => $averageRating,
            'ratingCount' => $ratingCount,
            'visibleCount' => $visibleCount,
            'hiddenCount' => $hiddenCount,
        ]);
    }

    public function toggle($ratingId)
    {
        $provider = auth()->user()->provider;

        if (!$provider) {
            abort(403);
        }

        $rating = ServiceRating::with('service')
            ->where('id', $ratingId)
            ->where('provider_id', $provider->id)
            ->firstOrFail();

        $rating->update([
            'is_visible' => !$rating->is_visible,
        ]);

        return redirect()->back()->with('flash_message', [
            'title' => 'Review Updated',
            'message' => $rating->is_visible
                ? 'This review is now visible on the service detail page.'
                : 'This review is now hidden from the service detail page.',
            'type' => 'success',
        ]);
    }
}