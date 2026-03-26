<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
    Route::post('checkout/{course}/{code?}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});

require __DIR__.'/settings.php';

Route::livewire('/courses', 'pages::welcome')->name('courses.index');
Route::livewire('/courses/{course}', 'pages::show')->name('courses.show');
Route::livewire('/', 'pages::home')->name('home');

Route::middleware(['auth'])->name('admin.')->prefix('admin/')->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('chat', ChatController::class)->name('chat.index');
    Route::get('categories', CategoryController::class)->name('categories.index');
});
