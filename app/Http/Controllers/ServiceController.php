<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceCategory;
use Illuminate\Validation\Rule;
use File;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with(['provider', 'serviceCategory', 'ratings'])
            ->where('is_active', 1)
            ->latest()
            ->get()
            ->map(function ($service) {
                $categoryIsActive = $service->serviceCategory && $service->serviceCategory->is_active;

                return [
                    'id' => $service->id,
                    'service_id' => $service->service_id,
                    'provider_id' => $service->provider_id,
                    'service_category_id' => $service->service_category_id,

                    'title' => $service->title,
                    'slug' => $service->slug,
                    'description' => $service->description,
                    'content' => $service->content,

                    'category' => $categoryIsActive
                        ? $service->serviceCategory->name
                        : null,

                    'category_is_active' => $categoryIsActive,

                    'price' => $service->price,
                    'image' => $service->image,

                    'jobs' => \App\Models\BookingInfo::where('service_id', $service->id)
                        ->where('status', 'COMPLETED')
                        ->count(),

                    'rating' => round($service->ratings->avg('rating') ?? 0, 1),
                    'reviews' => $service->ratings->count(),

                    'specialization' => $service->specialization,
                    'created_at' => $service->created_at,

                    'provider' => $service->provider,
                ];
            });

        return view('front.pages.custom-pages.services', compact('services'));
    }

    public function indexProvider()
    {
        $provider = auth()->user()->provider;

        $services = Service::with('serviceCategory')
            ->where('provider_id', $provider->id)
            ->latest()
            ->get();

        return view('admin.provserv', compact('services'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'service_category_id' => [
                'required',
                Rule::exists('service_categories', 'id')->where('is_active', true),
            ],
            'slug'           => 'nullable|string|max:255|unique:tbl_services,slug',
            'description'    => 'nullable|string',
            'content'        => 'nullable|string',
            // 'category'       => 'required|string',
            'specialization' => 'nullable|string|max:255',
            'price'          => 'required|numeric|max:30000',
            'image'          => 'image|mimes:jpg,jpeg,png,webp|max:5048',
            'is_active' => 'required|in:0,1',
        ]);

        $provider = auth()->user()->provider;

        if (!$provider) {
            return back()->with('error', 'Only providers can create services.');
        }

        if ($provider->service()->count() >= 5) {
            return back()->with('flash_message', [
                'title' => 'Limit Reached',
                'message' => 'Service limit reached. You can only create up to 5 services.',
                'type' => 'error'
            ]);
        }

        $slug = $request->slug
            ? Str::slug($request->slug)
            : Str::slug($request->title) . '-' . uniqid();

        // ✅ Generate Short Unique ID: SE-2026-ABCDE
        do {
            $serviceId = 'SE-' . now()->year . '-' . strtoupper(Str::random(5));
        } while (Service::where('service_id', $serviceId)->exists());

        $service = Service::create([
            'service_id'     => $serviceId,
            'provider_id'    => $provider->id,
            'service_category_id' => $request->service_category_id,
            'title'          => $request->title,
            'slug'           => $slug,
            'description'    => $request->description,
            'content'        => $request->content,
            // 'category'       => $request->category,
            'specialization' => $request->specialization,
            'price'          => $request->price,
            'image'          => null,
            'is_active'      => $request->is_active,
        ]);

        if ($request->hasFile('image')) {
            $file_upload_path = $this->uploadFile($request->file('image'), null, 'service_images');
            $service->update(['image' => $file_upload_path]);
        }

        return redirect()->route('provider.service')->with('flash_message', [
            'title' => '',
            'message' => 'Service created successfully.',
            'type' => 'success'
        ]);
    }
    
    public function uploadFile($file, $type = null, $path)
    {
        $extension = $file->getClientOriginalExtension();
        $file_name = substr(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 0, 30) . '-' . time() . ($type ? '-' . $type : '') . '.' . $extension;
        $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '', $file_name);
        $file_path = '/uploads/' . $path;
        $directory = public_path() . $file_path;

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true);
        }

        $file->move($directory, $file_name);
        return $file_path . '/' . $file_name;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $service = Service::with([
                'provider',
                'serviceCategory',
                'ratings',
                'ratings.customer',
                'ratings.customer.user',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedServices = Service::with([
                'provider',
                'serviceCategory',
                'ratings',
            ])
            ->where('service_category_id', $service->service_category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', 1)
            ->latest()
            ->limit(3)
            ->get();

        $categoryIsVisible = $service->serviceCategory && $service->serviceCategory->is_active;

        $ratings = $service->ratings ?? collect();
        $providerRatings = \App\Models\ServiceRating::where('provider_id', $service->provider_id)->get();

        $reviews = $ratings
            ->sortByDesc('created_at')
            ->map(function ($rating) {
                $customer = $rating->customer;
                $user = $customer?->user;

                $customerName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));

                if (empty($customerName)) {
                    $customerName = 'Customer';
                }

                return (object) [
                    'id' => $rating->id,
                    'rating' => $rating->rating,
                    'comment' => $rating->comment,
                    'date' => $rating->created_at?->format('M d, Y'),
                    'customer_name' => $customerName,
                    'customer_email' => $user->email ?? 'No email',
                    'customer_image' => $customer->profile_image ?? null,
                    'customer_initials' => strtoupper(
                        substr($customer->first_name ?? 'C', 0, 1) .
                        substr($customer->last_name ?? '', 0, 1)
                    ),
                ];
            })
            ->values();

        $data = [
            'id' => $service->id,
            'title' => $service->title,
            'slug' => $service->slug,

            'service_category_id' => $service->service_category_id,
            'category' => $categoryIsVisible
                ? $service->serviceCategory->name
                : null,

            'description' => $service->description,
            'content' => $service->content,
            'image' => $service->image ? asset($service->image) : asset('images/default_service_banner.png'),

            'jobs' => \App\Models\BookingInfo::where('service_id', $service->id)
                ->where('status', 'COMPLETED')
                ->count(),

            'price' => $service->price,

            'rating' => round($ratings->avg('rating') ?? 0, 1),
            'reviews' => $ratings->count(),
            'rating_comments' => $reviews,

            'provider_rating' => round($providerRatings->avg('rating') ?? 0, 1),
            'provider_reviews' => $providerRatings->count(),

            'specialization' => $service->specialization,
            'created_at' => $service->created_at->format('M d, Y'),

            'provider_name' => $service->provider
                ? $service->provider->first_name . ' ' . $service->provider->last_name
                : 'Unknown Provider',

            'provider_id' => $service->provider?->id,
            'provider_fname' => $service->provider?->first_name,
            'provider_lname' => $service->provider?->last_name,
            'provider_profile' => $service->provider?->profile_image,

            'provider_exp' => $service->provider->year_exp ?? 0,
            'provider_area' => ($service->provider->province ?? 'Unknown Area') . ' & nearby',
        ];

        return view('front.pages.custom-pages.service-detail', [
            'service' => (object) $data,
            'related' => $relatedServices,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.page.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255',
            'slug'           => 'nullable|string|max:255|unique:tbl_services,slug,' . $id,
            'description'    => 'nullable|string',
            'content'        => 'nullable|string',
            'service_category_id' => [
                'required',
                Rule::exists('service_categories', 'id')->where('is_active', true),
            ],
            // 'category'       => 'required|string',
            'specialization' => 'nullable|string|max:255',
            'price'          => 'nullable|numeric',
            'image'          => $service->image
                ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'image|mimes:jpg,jpeg,png,webp|max:5048',
            'is_active' => 'required|in:0,1',
        ]);

        $slug = $request->slug
            ? \Illuminate\Support\Str::slug($request->slug)
            : \Illuminate\Support\Str::slug($request->title);

        $service->update([
            'title'          => $request->title,
            'slug'           => $slug,
            'service_category_id' => $request->service_category_id,
            'description'    => $request->description,
            'content'        => $request->content,
            // 'category'       => $request->category,
            'specialization' => $request->specialization,
            'price'          => $request->price,
            'is_active'      => $request->is_active
        ]);

        if ($request->hasFile('image')) {
            $file_upload_path = $this->uploadFile($request->file('image'), null, 'service_images');
            $service->update(['image' => $file_upload_path]);
        }

        return redirect()->route('provider.service')->with('flash_message', [
            'title' => '',
            'message' => 'Service updated successfully.',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        $service->delete(); // soft delete

        return redirect()->route('provider.service')->with('flash_message', [
            'title' => '',
            'message' => 'Service deleted successfully.',
            'type' => 'success'
        ]);
    }
}
