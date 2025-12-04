<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilityController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TypePaymentController;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\Route;

Route::get('/',[GuestController::class,'index'])->name('guest.index');
Route::get('/kamar/{id}',[GuestController::class,'showRoom'])->name('showRoom');

Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('fasilities', FasilityController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('type-payments', TypePaymentController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('testimoni',TestimoniController::class);

    // gambar rooms
    Route::get('/images/room/{id}',[ImagesController::class,'index'])->name('images.index');
    Route::post('/images',[ImagesController::class,'store'])->name('images.store');
    Route::delete('/images/{id}',[ImagesController::class,'destroy'])->name('images.destroy');

    //confirm payment
    Route::put('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
    Route::put('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
    Route::get('suuccess-payment/{id}',[PaymentController::class,'success'])->name('booking.success');


    Route::resource('settings',SettingController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
