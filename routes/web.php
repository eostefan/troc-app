<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OfferAcceptController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'items');
Route::resource('items', ItemController::class)->only(['index', 'show']);

Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('register', [AccountController::class, 'create'])->name('register');
Route::post('register', [AccountController::class, 'store'])->name('register.store');

Route::resource('items.offer', OfferController::class)->only(['store'])->middleware('auth');

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {

    Route::name('items.restore')
        ->put('items/{item}/restore', [ProfileController::class, 'restore'])
        ->withTrashed();

    Route::resource('items', ProfileController::class)->except('update')->withTrashed();

    Route::name('items.update')
            ->post('items/{item}/edit', [ProfileController::class, 'updateItem']);

    Route::name('offer.accept')
            ->put('offer/{offer}/accept', OfferAcceptController::class);

    Route::resource('photos', PhotoController::class)->only('destroy');

});
