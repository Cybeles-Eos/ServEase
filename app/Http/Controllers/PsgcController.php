<?php

namespace App\Http\Controllers;

use App\Services\PhilippineZipcodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PsgcController extends Controller
{
    private const BASE_URL = 'https://psgc.gitlab.io/api';

    public function cities()
    {
        return $this->proxy('cities-municipalities/');
    }

    public function barangays(string $cityCode)
    {
        return $this->proxy("cities-municipalities/{$cityCode}/barangays/");
    }

    public function provinces()
    {
        return $this->proxy('provinces/');
    }

    public function regions()
    {
        return $this->proxy('regions/');
    }

    public function zipcode(Request $request, PhilippineZipcodeService $zipcodeService)
    {
        $zipcode = $zipcodeService->lookup(
            (string) $request->query('city', ''),
            (string) $request->query('barangay', '')
        );

        return response()->json([
            'zipcode' => $zipcode,
        ]);
    }

    private function proxy(string $path)
    {
        $cacheKey = 'psgc:' . str_replace('/', ':', trim($path, '/'));

        $data = Cache::remember($cacheKey, now()->addDay(), function () use ($path) {
            $response = Http::timeout(30)->get(self::BASE_URL . '/' . $path);

            if (! $response->successful()) {
                abort(502, 'Unable to load location data.');
            }

            return $response->json();
        });

        return response()->json($data);
    }
}
