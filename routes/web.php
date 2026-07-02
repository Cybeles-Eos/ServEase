<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthManagerController;
use App\Http\Controllers\Auth\RegisterOtpController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BookingInfoController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\BookingReceiptController;
use App\Http\Controllers\ServiceRatingController;
use App\Http\Controllers\ProviderServiceReviewController;
use App\Http\Controllers\PsgcController;
use App\Http\Controllers\ServiceReportController;
use App\Http\Controllers\AdminReportController;

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
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/privacy-policy', function () {
    return view('front.pages.custom-pages.privacy-policy');
})->name('privacy.policy');
Route::get('/terms-and-conditions', function () {
    return view('front.pages.custom-pages.terms-and-conditions');
})->name('terms.conditions');

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

Route::prefix('psgc')->group(function () {
    Route::get('/cities-municipalities', [PsgcController::class, 'cities'])->name('psgc.cities');
    Route::get('/cities-municipalities/{cityCode}/barangays', [PsgcController::class, 'barangays'])->name('psgc.barangays');
    Route::get('/provinces', [PsgcController::class, 'provinces'])->name('psgc.provinces');
    Route::get('/regions', [PsgcController::class, 'regions'])->name('psgc.regions');
    Route::get('/zipcode', [PsgcController::class, 'zipcode'])->name('psgc.zipcode');
});

Route::get('/provider-signup', [AuthManagerController::class, 'showProvReg'])->name('provider-signup');
Route::post('/provider-signup-c', [AuthManagerController::class, 'signupProvider'])->name('provider-signup.post');

Route::get('/verify-email-otp', [RegisterOtpController::class, 'showVerifyForm'])
    ->name('otp.verify.page');

Route::post('/verify-email-otp', [RegisterOtpController::class, 'verifyOtp'])
    ->name('otp.verify');

Route::post('/resend-email-otp', [RegisterOtpController::class, 'resendOtp'])
    ->name('otp.resend');


Route::get('/forgot-password', [AuthManagerController::class, 'showForgotPassword'])
    ->name('password.forgot');

Route::post('/forgot-password', [AuthManagerController::class, 'sendForgotPasswordOtp'])
    ->name('password.forgot.send');

Route::get('/forgot-password/verify-otp', [AuthManagerController::class, 'showForgotPasswordOtp'])
    ->name('password.otp.page');

Route::post('/forgot-password/verify-otp', [AuthManagerController::class, 'verifyForgotPasswordOtp'])
    ->name('password.otp.verify');

Route::post('/forgot-password/resend-otp', [AuthManagerController::class, 'resendForgotPasswordOtp'])
    ->name('password.otp.resend');

Route::get('/reset-password', [AuthManagerController::class, 'showResetPassword'])
    ->name('password.reset.page');

Route::post('/reset-password', [AuthManagerController::class, 'updateForgotPassword'])
    ->name('password.reset.update');

Route::middleware('auth')->group(function () {

    // Normal URL
    Route::get('/booking-receipt/{id}', [BookingReceiptController::class, 'show'])
        ->name('booking.receipt');


    Route::middleware('role:admin')->group(function () {
        
        Route::redirect('/admin', '/admin/dashboard');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/ongoing-bookings', [AdminController::class, 'ongoingBookings'])->name('admin.ongoing-bookings');
        Route::get('/admin/audit-logs', [AdminController::class, 'auditLogs'])->name('admin.audit-logs');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/admin/customers/{customer}/document/valid-id', [AdminController::class, 'showCustomerValidIdDocument'])->name('admin.customers.document.valid-id');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Applicants
        Route::get('/admin/applicants', [AdminController::class, 'applicants'])->name('admin.applicants');
        Route::get('/admin/applicants/{provider}', [AdminController::class, 'showApplicant'])->name('admin.applicants.show');
        Route::get('/admin/applicants/{provider}/document/{document}', [AdminController::class, 'showApplicantDocument'])->name('admin.applicants.document');
        Route::post('/admin/applicants/{provider}/accept', [AdminController::class, 'acceptApplicant'])->name('admin.applicants.accept');
        Route::post('/admin/applicants/{provider}/decline', [AdminController::class, 'declineApplicant'])->name('admin.applicants.decline');
        Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports');
        Route::post('/admin/reports/providers/{provider}/deactivate', [AdminReportController::class, 'deactivateProvider'])->name('admin.reports.provider.deactivate');

        // Contact Messages
        Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
        Route::get('/admin/contacts/{contact}', [ContactController::class, 'adminShow'])->name('admin.contacts.show');

        //Admin General Setting
        Route::get('/admin/setting', [AdminController::class, 'setting'])->name('admin.setting');
        
        // Service Category inside General Setting
        Route::post('/admin/setting/service-categories', [AdminController::class, 'storeServiceCategory'])
            ->name('admin.setting.service-categories.store');
        Route::put('/admin/setting/service-categories/{serviceCategory}', [AdminController::class, 'updateServiceCategory'])
            ->name('admin.setting.service-categories.update');
        Route::delete('/admin/setting/service-categories/{serviceCategory}', [AdminController::class, 'destroyServiceCategory'])
            ->name('admin.setting.service-categories.destroy');

        Route::put('/admin/setting/platform-contact', [AdminController::class, 'updatePlatformContact'])
            ->name('admin.setting.platform-contact.update');
        Route::put('/admin/setting/platform-branding', [AdminController::class, 'updatePlatformBranding'])
            ->name('admin.setting.platform-branding.update');
        Route::put('/admin/setting/otp-feature', [AdminController::class, 'updateOtpFeature'])
            ->name('admin.setting.otp-feature.update');

        Route::post('/admin/notifications/mark-read', [AdminController::class, 'markAdminNotificationsRead'])
            ->name('admin.notifications.mark-read');
    });

    // Provider
    Route::middleware('role:provider')->group(function () {

        Route::redirect('/provider', '/provider/dashboard');
        Route::get('/provider/declined', [ProviderController::class, 'declined'])->name('provider.declined');
        Route::delete('/provider/declined/records', [ProviderController::class, 'deleteDeclinedRecords'])->name('provider.declined.records.delete');
        Route::get('/provider/resubmit', [ProviderController::class, 'resubmit'])->name('provider.resubmit');
        Route::post('/provider/resubmit', [ProviderController::class, 'updateResubmission'])->name('provider.resubmit.update');

        Route::middleware('provider.accepted')->group(function () {
            //Route::get('/provider/dashboard', function () {return view('admin.provdashboard');})->name('provider.dashboard');
            Route::get('/provider/dashboard', [ProviderController::class, 'dashboard'])
                ->name('provider.dashboard');
            // Route::get('/provider/bookings', function () {return view('admin.provbookings');})->name('provider.bookings');
            Route::get('/provider/bookings', [BookingRequestController::class, 'providerRequests'])->name('provider.bookings');
            Route::get('/provider/booking-calendar', [ProviderController::class, 'bookingCalendar'])->name('provider.booking-calendar');
            
            
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
        Route::post('/booking/{bookingRequest}/report-service', [ServiceReportController::class, 'store'])->name('customer.booking.report-service');
        Route::post('/customer/notifications/mark-read', [BookingRequestController::class, 'markCustomerNotificationsRead'])->name('customer.notifications.mark-read');

    });

});
