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




/**
 * 
 * Admin Routes
 */

Route::get('/login', [AuthManagerController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthManagerController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthManagerController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthManagerController::class, 'showSignup'])->name('signup');
Route::post('/register', [AuthManagerController::class, 'signup'])->name('signup.post');

Route::get('/dashboard', [AuthManagerController::class, 'showDashboard'])->name('dashboard');