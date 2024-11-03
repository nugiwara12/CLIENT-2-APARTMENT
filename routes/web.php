<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ApartmentRoomController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InquiryController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


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
    Route::post('restore/{id}', 'restore')->name('usermanagement.restore'); // Add restore route here
    Route::put('/usermanagement/{id}/setDueDate', [UserManagementController::class, 'setDueDate'])->name('usermanagement.setDueDate');
});

Route::post('reminder/{id}/reminder', [UserManagementController::class, 'reminder'])->name('reminder.reminder');


Route::get('/booking', [ApartmentRoomController::class, 'index'])->name('booking');
Route::get('/booking/forms', [ApartmentRoomController::class, 'forms'])->name('booking.forms');
Route::post('booking', [ApartmentRoomController::class, 'store'])->name('booking.store');
Route::patch('booking/update/{id}', [ApartmentRoomController::class, 'update'])->name('booking.update');
Route::delete('booking/destroy/{id}', [ApartmentRoomController::class, 'destroy'])->name('booking.destroy');

Route::get('/send-notification', [NotificationController::class, 'sendNotification']);

Route::get('/about', [AboutController::class, 'index'])->name('nav-contents.about_us');

Route::middleware(['auth'])->group(function () {
    // Route to show the available rooms
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    // Route to show the create room form
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    // Route to store a new room
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    // Route to show the edit form for a room
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    // Route to update a room
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    // Route to delete a room
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    // Add restore route here
    Route::post('/rooms/restore/{id}', [RoomController::class, 'restore'])->name('rooms.restore');
    // Route to show room details
    Route::get('/rooms/details/{id}', [RoomController::class, 'show'])->name('rooms.details');
});


Route::get('/contact', [ContactController::class, 'create'])->name('welcome');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contacts', [ContactController::class, 'index'])->name('contact.index'); // List all contacts
Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit'); // Edit a specific contact
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contact.update'); // Update a specific contact
Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
Route::post('/contact/{id}', [ContactController::class, 'restore'])->name('contact.restore');


// Inquiry Routes
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
Route::get('/inquiries/{id}/edit', [InquiryController::class, 'edit'])->name('inquiries.edit');
Route::put('/inquiries/{id}', [InquiryController::class, 'update'])->name('inquiries.update');
Route::delete('/inquiries/{id}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
Route::post('/inquiry/{id}', [InquiryController::class, 'restore'])->name('inquiry.restore');
Route::post('inquirs/{id}/approved', [InquiryController::class, 'approved'])->name('inquiries.approved');




// Display all payments
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

// Show the form for creating a new payment
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');

// Store a new payment record
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

// Show the form for editing an existing payment
Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');

// Update an existing payment record
Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');

// Delete a specific payment record
Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
