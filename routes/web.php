<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BookingInfoController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\BookingReceiptController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\ProviderServiceReviewController;

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

    // Normal URL
    Route::get('/booking-receipt/{id}', [BookingReceiptController::class, 'show'])
        ->name('booking.receipt');


    Route::middleware('role:admin')->group(function () {
        
        Route::redirect('/admin', '/admin/dashboard');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        //Admin General Setting
        Route::get('/admin/setting', [AdminController::class, 'setting'])->name('admin.setting');
        
        // Service Category inside General Setting
        Route::post('/admin/setting/service-categories', [AdminController::class, 'storeServiceCategory'])
            ->name('admin.setting.service-categories.store');
        Route::put('/admin/setting/service-categories/{serviceCategory}', [AdminController::class, 'updateServiceCategory'])
            ->name('admin.setting.service-categories.update');
        Route::delete('/admin/setting/service-categories/{serviceCategory}', [AdminController::class, 'destroyServiceCategory'])
            ->name('admin.setting.service-categories.destroy');
    });

    // Provider
    Route::middleware('role:provider')->group(function () {

        Route::redirect('/provider', '/provider/dashboard');
        //Route::get('/provider/dashboard', function () {return view('admin.provdashboard');})->name('provider.dashboard');
        Route::get('/provider/dashboard', [ProviderController::class, 'dashboard'])
            ->name('provider.dashboard');
        // Route::get('/provider/bookings', function () {return view('admin.provbookings');})->name('provider.bookings');
        Route::get('/provider/bookings', [BookingRequestController::class, 'providerRequests'])->name('provider.bookings');
        
        
        Route::get('/provider/service', [ServiceController::class, 'indexProvider'])->name('provider.service');

        // Provider Service Creation
        Route::get('/provider/service/create', [ServiceController::class, 'create'])->name('create-service');
        Route::post('/provider/service/store', [ServiceController::class, 'store'])->name('provider.service.store');
        Route::get('/provider/service/edit/{id}', [ServiceController::class, 'edit'])->name('edit-service');
        Route::put('/provider/service/update/{id}', [ServiceController::class, 'update'])->name('provider.service.update');
        Route::delete('/provider/service/delete/{id}', [ServiceController::class, 'destroy'])->name('provider.service.delete');
        
        // Provider Comments Page
        Route::get('/provider/service/{service}/reviews', [ProviderServiceReviewController::class, 'index'])->name('provider.service.reviews');
        Route::post('/provider/service-rating/{rating}/toggle-visibility', [ProviderServiceReviewController::class, 'toggle'])->name('provider.service-rating.toggle-visibility');

        // Provider Setting
        Route::post('/provider/setting/update', [ProviderController::class, 'updateSetting'])->name('provider.setting.update');
        Route::get('/provider/setting', [ProviderController::class, 'setting'])->name('provider.setting');

        // Provider Booking Actions
        Route::post('/provider/booking-request/{id}/accept', [BookingRequestController::class, 'accept'])->name('provider.booking-request.accept');
        Route::post('/provider/booking-request/{id}/decline', [BookingRequestController::class, 'decline'])->name('provider.booking-request.decline');
        Route::post('/provider/booking-request/{id}/cancel', [BookingRequestController::class, 'cancel'])->name('provider.booking-request.cancel');
        Route::post('/provider/booking-request/{id}/complete', [BookingRequestController::class, 'markComplete'])->name('provider.booking-request.complete');

        // Notification
        Route::post('/provider/notifications/mark-read', [BookingRequestController::class, 'markProviderNotificationsRead'])->name('provider.notifications.mark-read');
        
    });

    // Customer Route
    Route::middleware('role:customer')->group(function () {
        
        Route::redirect('/customer', '/customer/dashboard');
        Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/bookings', function () {return view('admin.cusbookings');})->name('customer.bookings');

        // Customer Setting
        Route::post('/customer/setting/update', [CustomerController::class, 'updateSetting'])->name('customer.setting.update');
        Route::get('/customer/setting', [CustomerController::class, 'setting'])->name('customer.setting');

        Route::post('/customer/book', [BookingInfoController::class, 'store'])->name('customer.book');
        Route::post('/customer/booking-request/{id}/cancel', [BookingRequestController::class, 'customerCancel'])->name('customer.booking.cancel');

        Route::post('/booking/{bookingRequest}/rate-service', [ServiceRatingController::class, 'store'])->name('customer.booking.rate-service');
        Route::post('/customer/notifications/mark-read', [BookingRequestController::class, 'markCustomerNotificationsRead'])->name('customer.notifications.mark-read');

    });

});

