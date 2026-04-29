<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Services\BookingStatusService;

class AuthManagerController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // public function showDashboard()
    // {

    //     return view('admin.dashboard');
    // }
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            app(BookingStatusService::class)->updateAllDueBookings(); //Update Status

            $user = Auth::user();   

            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            }

            if ($user->isProvider()) {
                return redirect('/provider/dashboard');
            }

            return redirect('customer/dashboard'); // customer
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Logout authenticated user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showSignup()
    {
        return view('admin.auth.register');
    }

    public function showProvReg()
    {
        return view('admin.auth.provider-register');
    }

    public function signup(Request $request)
    {
        // Customer Creation Account
        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([ 
            'name' => $validated['fname'] . ' ' . $validated['lname'],      // temporary, soon this data will be removed or act as username
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'customer', 
        ]);
        $user->customer()->create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
        ]);

        return redirect('/login');
    }

    public function signupProvider(Request $request)
    {
        $validated = $request->validate([
            'fname'      => ['required', 'string', 'max:255'],
            'lname'      => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'number'     => ['required', 'string'], // phone_num
            'address'    => ['required', 'string'], // home_address
            'province'   => ['required', 'string'],
            'zipcode'    => ['required', 'string'], // zip
            'profession' => ['required', 'string'],
            'experience' => ['required', 'integer'], // year_exp
            'password'   => ['required', 'min:8', 'confirmed'],
        ]);
        
        // Create the Base User Account
        $user = User::create([
            'name'     => $validated['fname'] . ' ' . $validated['lname'],      // temporary, soon this data will be removed or act as username
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'provider', // Set role to provider
        ]);

        // Create the Provider Profile
        $user->provider()->create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
            'phone_num'    => $validated['number'],
            'home_address' => $validated['address'],
            'province'     => $validated['province'],
            'zipcode'          => $validated['zipcode'],
            'profession'   => $validated['profession'],
            'year_exp'     => $validated['experience'],
        ]);

        return redirect('/login')->with('success', 'Provider account created successfully!');
    }

}
