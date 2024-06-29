<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('website');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('is-admin')->group(function () {
        // users
        Route::get('/users/trashed', [UserController::class, 'trashed'])->name('users.trashed');
        Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore')->withTrashed();
        Route::delete('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete')->withTrashed();
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
