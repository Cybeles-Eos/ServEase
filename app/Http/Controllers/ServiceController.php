<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all and flatten the services with provider data
        $services = Service::with(['provider' => function($query) {
                $query->select('id', 'user_id', 'first_name', 'last_name');
            }])
            ->select('id', 'provider_id', 'title', 'category', 'description', 'jobs', 'rating', 'reviews', 'specialization', 'created_at')
            ->get()
            ->map(function ($service) {
                return [
                    'id'             => $service->id,
                    'title'          => $service->title,
                    'category'       => $service->category,
                    'provider'       => $service->provider->first_name . ' ' . $service->provider->last_name,
                    'description'    => $service->description,
                    'created_at'     => $service->created_at->format('Y-m-d'),
                    'jobs'           => $service->jobs,
                    'rating'         => $service->rating,
                    'reviews'        => $service->reviews,
                    'specialization' => $service->specialization ?? $service->category,
                ];
            });
        
        return view('front.pages.custom-pages.services', compact('services'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd($id);

        // DATA 1: Fetch primary service
        $service = Service::with('provider.user')->findOrFail($id);

        // DATA 2: Fetch Related Services
        $relatedServices = Service::where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        // Flatten primary data
        $data = [
            'id'             => $service->id,
            'title'          => $service->title,
            'category'       => $service->category,
            'description'    => $service->description,
            'jobs'           => $service->jobs,
            'rating'         => $service->rating,
            'reviews'        => $service->reviews,
            'specialization' => $service->specialization,
            'created_at'     => $service->created_at->format('M d, Y'),
            // Provider specific flattened data
            'provider_name'  => $service->provider->first_name . ' ' . $service->provider->last_name,
            'provider_exp'   => $service->provider->year_exp,
            'provider_area'  => $service->provider->province . ' & nearby', // Using fixed location logic
        ];

        // dd($data);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
