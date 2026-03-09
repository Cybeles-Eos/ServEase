<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Carbon\Carbon;

class ProviderController extends Controller
{
    // Index Settings
    public function setting()
    {
        $user = User::with('provider')->find(auth()->id());
        return view('admin.provsetting', compact('user'));
    }

    public function updateSetting(Request $request)
    {
        $request->validate([
            'first_name'   => 'nullable|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'home_address' => 'nullable|string|max:255',
            'province'         => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'zipcode'      => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'profession'   => 'nullable|string|max:255',
            'year_exp'     => 'nullable|string|max:20',

        ]);

        $user = auth()->user();
        $provider = $user->provider;

        /*
        |--------------------------------------------------------------------------
        | Handle Image Removal
        |--------------------------------------------------------------------------
        */
        if ($request->remove_profile_image == "1") {

            if ($provider->profile_image && file_exists(public_path($provider->profile_image))) {
                unlink(public_path($provider->profile_image));
            }

            $provider->profile_image = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Handle New Upload
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $this->uploadFile(
                $request->file('profile_image'),
                'profile',
                'provider_profiles'
            );

            $provider->profile_image = $profileImagePath;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Provider Table
        |--------------------------------------------------------------------------
        */
        $provider->first_name  = $request->first_name;
        $provider->last_name   = $request->last_name;
        $provider->phone_number= $request->phone_number;
        $provider->home_address     = $request->home_address;
        $provider->province        = $request->province;
        $provider->barangay     = $request->barangay;
        $provider->zipcode     = $request->zipcode;
        $provider->profession     = $request->profession;
        $provider->year_exp     = $request->year_exp;
        $provider->save();

        /*
        |--------------------------------------------------------------------------
        | Update Users Table
        |--------------------------------------------------------------------------
        */
        $user->name  = trim($request->first_name . ' ' . $request->last_name);
        $user->email = $request->email;
        $user->save();

        return redirect()->route('provider.setting')->with('flash_message', [
            'title' => '',
            'message' => 'Profile updated successfully.',
            'type' => 'success'
        ]);
    }

    // Helper function to handle file uploads
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
}
