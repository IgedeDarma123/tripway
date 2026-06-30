<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Route::get('/destinations/{destination}', [\App\Http\Controllers\DestinationController::class, 'show'])->name('destinations.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Google Login
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback']);

// Tours
Route::get('/tours', [\App\Http\Controllers\TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour:slug}', [\App\Http\Controllers\TourController::class, 'show'])->name('tours.show');
Route::get('/tours/{tour}/packages', [\App\Http\Controllers\TourController::class, 'packages'])->name('tours.packages');

// Bookings
Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
Route::get('/bookings/{booking}/ticket', [\App\Http\Controllers\BookingController::class, 'downloadTicket'])->name('bookings.ticket');

// Payment
Route::get('/payment/{booking}', [\App\Http\Controllers\BookingController::class, 'showPayment'])->name('payment.show');
Route::get('/payment/{booking}/order-detail', [\App\Http\Controllers\BookingController::class, 'showOrderDetail'])->name('payment.order-detail');
Route::post('/payment/{booking}/mock', [\App\Http\Controllers\BookingController::class, 'processMockPayment'])->name('payment.process-mock');

// Payment Proof Upload (Manual Transfer)
Route::get('/payment/{booking}/upload', [\App\Http\Controllers\BookingController::class, 'showUploadProof'])->name('payment.upload.show');
Route::post('/payment/{booking}/upload', [\App\Http\Controllers\BookingController::class, 'uploadPaymentProof'])->name('payment.upload');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // Tours CRUD
    Route::get('/tours', [\App\Http\Controllers\AdminController::class, 'toursIndex'])->name('tours.index');
    Route::get('/tours/create', [\App\Http\Controllers\AdminController::class, 'toursCreate'])->name('tours.create');
    Route::post('/tours', [\App\Http\Controllers\AdminController::class, 'toursStore'])->name('tours.store');
    Route::get('/tours/{tour}/edit', [\App\Http\Controllers\AdminController::class, 'toursEdit'])->name('tours.edit');
    Route::put('/tours/{tour}', [\App\Http\Controllers\AdminController::class, 'toursUpdate'])->name('tours.update');
    Route::delete('/tours/{tour}', [\App\Http\Controllers\AdminController::class, 'toursDestroy'])->name('tours.destroy');

    // Publish/Unpublish tour (is_active)
    Route::patch('/tours/{tour}/toggle-active', [\App\Http\Controllers\AdminController::class, 'toursToggleActive'])
        ->name('tours.toggle-active');


    // Tour Packages CRUD
    Route::get('/packages', [\App\Http\Controllers\AdminController::class, 'packagesIndex'])->name('packages.index');
    Route::post('/tours/{tour}/packages', [\App\Http\Controllers\AdminController::class, 'packagesStore'])->name('tours.packages.store');
    Route::put('/tours/{tour}/packages/{package}', [\App\Http\Controllers\AdminController::class, 'packagesUpdate'])->name('tours.packages.update');
    Route::delete('/tours/{tour}/packages/{package}', [\App\Http\Controllers\AdminController::class, 'packagesDestroy'])->name('tours.packages.destroy');

    // Package Groups (untuk mode Private)
    Route::post('/packages/{package}/groups', [\App\Http\Controllers\AdminController::class, 'groupsStore'])->name('packages.groups.store');
    Route::put('/packages/{package}/groups/{group}', [\App\Http\Controllers\AdminController::class, 'groupsUpdate'])->name('packages.groups.update');
    Route::delete('/packages/{package}/groups/{group}', [\App\Http\Controllers\AdminController::class, 'groupsDestroy'])->name('packages.groups.destroy');

    // Package Addons (untuk mode Sharing)
    Route::post('/packages/{package}/addons', [\App\Http\Controllers\AdminController::class, 'addonsStore'])->name('packages.addons.store');
    Route::put('/packages/{package}/addons/{addon}', [\App\Http\Controllers\AdminController::class, 'addonsUpdate'])->name('packages.addons.update');
    Route::delete('/packages/{package}/addons/{addon}', [\App\Http\Controllers\AdminController::class, 'addonsDestroy'])->name('packages.addons.destroy');

    // Categories CRUD
    Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categoriesIndex'])->name('categories.index');
    Route::post('/categories', [\App\Http\Controllers\AdminController::class, 'categoriesStore'])->name('categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\AdminController::class, 'categoriesUpdate'])->name('categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\AdminController::class, 'categoriesDestroy'])->name('categories.destroy');

    // Destinations CRUD
    Route::get('/destinations', [\App\Http\Controllers\AdminController::class, 'destinationsIndex'])->name('destinations.index');
    Route::post('/destinations', [\App\Http\Controllers\AdminController::class, 'destinationsStore'])->name('destinations.store');
    Route::put('/destinations/{destination}', [\App\Http\Controllers\AdminController::class, 'destinationsUpdate'])->name('destinations.update');
    Route::delete('/destinations/{destination}', [\App\Http\Controllers\AdminController::class, 'destinationsDestroy'])->name('destinations.destroy');

// Bookings
    Route::get('/bookings', [\App\Http\Controllers\AdminController::class, 'bookingsIndex'])->name('bookings.index');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'bookingsShow'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\AdminController::class, 'bookingsUpdateStatus'])->name('bookings.update-status');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\AdminController::class, 'bookingsDestroy'])->name('bookings.destroy');

    // Payment Confirmation
    Route::get('/bookings/{booking}/proof', [\App\Http\Controllers\AdminController::class, 'bookingsViewProof'])->name('bookings.proof');
    Route::post('/bookings/{booking}/confirm-payment', [\App\Http\Controllers\AdminController::class, 'bookingsConfirmPayment'])->name('bookings.confirm-payment');
    Route::post('/bookings/{booking}/reject-payment', [\App\Http\Controllers\BookingController::class, 'bookingsRejectPayment'])->name('bookings.reject-payment');

// Reviews & Fake Reviews
    Route::get('/reviews', [\App\Http\Controllers\AdminController::class, 'reviewsIndex'])->name('reviews.index');
    Route::post('/reviews', [\App\Http\Controllers\AdminController::class, 'reviewsStore'])->name('reviews.store');
    Route::post('/reviews/generate-fake', [\App\Http\Controllers\AdminController::class, 'reviewsGenerateFake'])->name('reviews.generate-fake');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\AdminController::class, 'reviewsDestroy'])->name('reviews.destroy');

    // Payment Settings
    Route::get('/payments', [\App\Http\Controllers\AdminController::class, 'paymentsIndex'])->name('payments.index');
    Route::post('/payments', [\App\Http\Controllers\AdminController::class, 'paymentsStore'])->name('payments.store');
    Route::put('/payments/{payment}', [\App\Http\Controllers\AdminController::class, 'paymentsUpdate'])->name('payments.update');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\AdminController::class, 'paymentsDestroy'])->name('payments.destroy');
    Route::patch('/payments/{payment}/toggle', [\App\Http\Controllers\AdminController::class, 'paymentsToggle'])->name('payments.toggle');

    // Clear view cache
    Route::get('/clear-cache', function () {
        $exitCode = \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        return redirect()->route('admin.dashboard')->with('success', 'Cache berhasil dibersihkan!');
    })->name('clear-cache');
});
