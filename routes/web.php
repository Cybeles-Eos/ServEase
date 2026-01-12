<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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

// Admin Routes
Route::get('/admin/login', function () {
    return view('admin.auth.login');
});
Route::redirect('/admin', '/admin/login');

// Customer Routes
Route::view('/customer/dashboard', 'customers.dashboard');

// Provider Routes
Route::get('/provider/login', function () {
    return view('providers.auth.login');
});
Route::get('/provider/signin', function () {
    return view('providers.auth.signin');
});