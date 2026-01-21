<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthManagerController;

Route::get('/', function () {
    return view('front.pages.custom-pages.home');
});
Route::get('/about-us', function () {
    return view('front.pages.custom-pages.about-us');
});


/** 
 * 
 * Contact Routes
 */
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

/**
 * 
 * Dummy Route (Change on backend code)
 */
Route::get('/services', function () {
    return view('front.pages.custom-pages.services');
});
Route::get('/service-detail', function () {
    return view('front.pages.custom-pages.service-detail');
});




/**
 * 
 * Admin Routes
 */

Route::get('/login', [AuthManagerController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthManagerController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthManagerController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthManagerController::class, 'showSignup'])->name('signup');
Route::post('/register', [AuthManagerController::class, 'signup'])->name('signup.post');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::middleware('role:provider')->get('/provider/dashboard', function () {
        return view('admin.provdashboard');
    })->name('provider.dashboard');

    Route::middleware('role:customer')->get('/dashboard', function () {
        return view('admin.cusdashboard');
    })->name('customer.dashboard');
});
