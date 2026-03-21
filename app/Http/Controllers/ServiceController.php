<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('provider')
            ->where('is_active',1)
            ->latest()
            ->get();

        return view('front.pages.custom-pages.services', compact('services'));
    }

    public function indexProvider()
    {
        $provider = auth()->user()->provider;
        $services = Service::where('provider_id', $provider->id)->get();

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
            'slug'           => 'nullable|string|max:255|unique:tbl_services,slug',
            'description'    => 'nullable|string',
            'content'        => 'nullable|string',
            'category'       => 'required|string',
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
            'title'          => $request->title,
            'slug'           => $slug,
            'description'    => $request->description,
            'content'        => $request->content,
            'category'       => $request->category,
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
        // Fetch service by slug (NOT ID)
        $service = Service::with('provider')
            ->where('slug', $slug)
            ->firstOrFail();

        // Fetch Related Services
        $relatedServices = Service::where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        // Flatten primary data safely
        $data = [
            'id'             => $service->id,
            'title'          => $service->title,
            'slug'           => $service->slug,
            'category'       => $service->category,
            'description'    => $service->description,
            'content'           => $service->content,
            'image'          => $service->image ? asset($service->image) : asset('images/default_service_banner.png'),
            'jobs'           => '0',
            'price'           => $service->price,
            'rating'         => $service->rating,
            'reviews'        => '0',
            'specialization' => $service->specialization,
            'created_at'     => $service->created_at->format('M d, Y'),

            // Provider info (null-safe)
            'provider_name'  => $service->provider
                                    ? $service->provider->first_name . ' ' . $service->provider->last_name
                                    : 'Unknown Provider',

            'provider_id' => $service->provider->id,
            'provider_fname' => $service->provider->first_name,
            'provider_lname' => $service->provider->last_name,
            'provider_profile' => $service->provider->profile_image,

            'provider_exp'   => $service->provider->year_exp ?? 0,
            'provider_area'  => ($service->provider->province ?? 'Unknown Area') . ' & nearby',
        ];

        return view('front.pages.custom-pages.service-detail', [
            'service' => (object) $data,
            'related' => $relatedServices
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
            'category'       => 'required|string',
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
            'description'    => $request->description,
            'content'        => $request->content,
            'category'       => $request->category,
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
