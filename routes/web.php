<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BookingInfoController;
use App\Http\Controllers\BookingRequestController;


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
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
// Route::get('/booking', function () {
//     return view('front.pages.custom-pages.book');
// });



/**
 * 
 * Admin Routes
 */

Route::get('/login', [AuthManagerController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthManagerController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthManagerController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthManagerController::class, 'showSignup'])->name('signup');
Route::post('/register', [AuthManagerController::class, 'signup'])->name('signup.post');

Route::get('/provider-signup', [AuthManagerController::class, 'showProvReg'])->name('provider-signup');
Route::post('/provider-signup-c', [AuthManagerController::class, 'signupProvider'])->name('provider-signup.post');

Route::middleware('auth')->group(function () {

    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Provider
    Route::middleware('role:provider')->group(function () {

        Route::redirect('/provider', '/provider/dashboard');
        Route::get('/provider/dashboard', function () {return view('admin.provdashboard');})->name('provider.dashboard');
        
        // Route::get('/provider/bookings', function () {return view('admin.provbookings');})->name('provider.bookings');
        Route::get('/provider/bookings', [BookingRequestController::class, 'providerRequests'])->name('provider.bookings');
        
        
        Route::get('/provider/service', [ServiceController::class, 'indexProvider'])->name('provider.service');

        // Provider Service Creation
        Route::get('/provider/service/create', [ServiceController::class, 'create'])->name('create-service');
        Route::post('/provider/service/store', [ServiceController::class, 'store'])->name('provider.service.store');
        Route::get('/provider/service/edit/{id}', [ServiceController::class, 'edit'])->name('edit-service');
        Route::put('/provider/service/update/{id}', [ServiceController::class, 'update'])->name('provider.service.update');
        Route::delete('/provider/service/delete/{id}', [ServiceController::class, 'destroy'])->name('provider.service.delete');

        // Provider Setting
        Route::post('/provider/setting/update', [ProviderController::class, 'updateSetting'])->name('provider.setting.update');
        Route::get('/provider/setting', [ProviderController::class, 'setting'])->name('provider.setting');
        
    });

    // Customer Route
    Route::middleware('role:customer')->group(function () {
        
        Route::redirect('/customer', '/customer/dashboard');
        Route::get('/customer/dashboard', function () {return view('admin.cusdashboard');})->name('customer.dashboard');
        Route::get('/customer/bookings', function () {return view('admin.cusbookings');})->name('customer.bookings');

        // Customer Setting
        Route::post('/customer/setting/update', [CustomerController::class, 'updateSetting'])->name('customer.setting.update');
        Route::get('/customer/setting', [CustomerController::class, 'setting'])->name('customer.setting');

        Route::post('/customer/book', [BookingInfoController::class, 'store'])->name('customer.book');
           
    });

});
