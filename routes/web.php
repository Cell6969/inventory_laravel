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

// Feature
Route::middleware('auth')->group(function () {
   Route::controller(\App\Http\Controllers\Feature\BrandController::class)->group(function () {
       Route::prefix('brands')->group(function () {
           Route::get('/all', 'view')->name('app.brands.all');
           Route::get('/create', 'viewCreate')->name('app.brands.create');
           Route::post('/create', 'store')->name('app.brands.store');
           Route::get('/edit/{id}', 'viewEdit')->name('app.brands.edit');
           Route::put('/edit/{id}', 'update')->name('app.brands.update');
           Route::delete('/delete/{id}', 'remove')->name('app.brands.delete');
       });
   });

   Route::controller(\App\Http\Controllers\Feature\WarehouseController::class)->group(function () {
       Route::prefix('warehouses')->group(function () {
           Route::get('/all', 'view')->name('app.warehouses.all');
           Route::get('/create', 'viewCreate')->name('app.warehouses.create');
           Route::post('/create', 'store')->name('app.warehouses.store');
           Route::get('/edit/{id}', 'viewEdit')->name('app.warehouses.edit');
           Route::put('/edit/{id}', 'update')->name('app.warehouses.update');
           Route::delete('/delete/{id}', 'remove')->name('app.warehouses.delete');
       });
   });

   Route::controller(\App\Http\Controllers\Feature\VendorController::class)->group(function () {
      Route::prefix('vendors')->group(function () {
          Route::get('/all', 'view')->name('app.vendors.all');
          Route::get('/create', 'viewCreate')->name('app.vendors.create');
          Route::post('/create', 'store')->name('app.vendors.store');
          Route::get('/edit/{id}', 'viewEdit')->name('app.vendors.edit');
          Route::put('/edit/{id}', 'update')->name('app.vendors.update');
          Route::delete('/delete/{id}', 'remove')->name('app.vendors.delete');
      });
   });
});

require __DIR__.'/auth.php';
