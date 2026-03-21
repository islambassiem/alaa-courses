<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::post('checkout/{course}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

require __DIR__.'/settings.php';

Route::livewire('/courses/{course}', 'pages::courses.show')->name('courses.show');
Route::livewire('/courses', 'pages::courses.show')->name('courses.learn');
