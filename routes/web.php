<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('backend.index');
})->middleware(['auth', 'verified'])->name('backend.index');

Route::get('/add-user', function () {
    return view('backend.add-user');
});

Route::get('/charts', function () {
    return view('backend.charts');
});

Route::get('/forms', function () {
    return view('backend.forms');
});

Route::get('/login', function () {
    return view('backend.login');
});

Route::get('/profile', function () {
    return view('backend.profile');
});

Route::get('/register', function () {
    return view('backend.register');
});

Route::get('/settings', function () {
    return view('backend.settings');
});

Route::get('/tables', function () {
    return view('backend.tables');
});
Route::get('/user-details', function () {
    return view('backend.user-details');
});
Route::get('/users', function () {
    return view('backend.users');
});
Route::get('/events', function () {
    return view('backend.events');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
