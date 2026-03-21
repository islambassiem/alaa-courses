<?php

use App\Http\Controllers\CheckoutController;
use App\Mail\UserEnrolled;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
    Route::post('checkout/{course}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

require __DIR__.'/settings.php';

Route::livewire('/courses/{course}', 'pages::show')->name('courses.show');

Route::get('mail', function () {
    $user = User::find(2);
    $course = Course::find(2);

    return (new UserEnrolled($course, $user))->render();
});
