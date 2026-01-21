<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('app.view.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('app.update.profile');
    Route::patch('/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('app.update.password');
    Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('app.logout');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store2FA'])->name('app.store.login');
    Route::get('/verification-login', [\App\Http\Controllers\Auth\VerificationTwoFactorController::class, 'show'])->name('app.view.verification.login');
    Route::post('/verification-login', [\App\Http\Controllers\Auth\VerificationTwoFactorController::class, 'store'])->name('app.store.verification.login');
    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('app.view.register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('app.store.register');
    Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('app.view.forgot.password');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('app.store.forgot.password');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('app.store.reset.password');
});

require __DIR__.'/auth.php';
