<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ApartmentRoomController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('email/verify/{id}/{hash}', function () {
})->middleware(['signed'])->name('verification.verify');    

Route::get('thankyou', [RegisteredUserController::class, 'showThankYou'])->name('thank.you');
require __DIR__.'/auth.php';

// USERMANAGEMENT ROUTES
Route::controller(UserManagementController::class)->prefix('usermanagement')->group(function () {
    Route::get('/usermanagement', 'index')->name('usermanagement'); 
    Route::get('create', 'create')->name('usermanagement.create');  
    Route::post('/', 'store')->name('usermanagement.store');   
    Route::get('{id}', 'show')->name('usermanagement.show');   
    Route::get('{id}/edit', 'edit')->name('usermanagement.edit');   
    Route::put('{id}', 'update')->name('usermanagement.update');  
    Route::delete('{id}', 'destroy')->name('usermanagement.destroy');
});

Route::get('/booking', [ApartmentRoomController::class, 'index'])->name('booking');
Route::post('booking', [ApartmentRoomController::class, 'store'])->name('booking.store');
Route::patch('booking/update/{id}', [ApartmentRoomController::class, 'update'])->name('booking.update');
Route::delete('booking/destroy/{id}', [ApartmentRoomController::class, 'destroy'])->name('booking.destroy');