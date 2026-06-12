<?php

use App\Http\Controllers\Loyalty\RewardController;
use App\Http\Controllers\Loyalty\CustomerController;
use App\Http\Controllers\Loyalty\LoyaltySettingController;

use Illuminate\Support\Facades\Auth;

// Dashboard
Route::get('/admin/loyalty', [CustomerController::class, 'dashboard'])->middleware('auth')->name('Loyalty.dashboard');

// Reward Routes
Route::get('/loyalty/reward', [RewardController::class, 'public'])->name('Reward.public');
Route::put('/admin/loyalty/reward/create', [RewardController::class, 'store'])->middleware('auth')->name('Reward.store');

// Customer Routes
Route::get('/admin/loyalty/customers/{filter}', [CustomerController::class, 'index'])->middleware('auth')->name('Customer.index');
Route::get('/admin/loyalty/customer/create', [CustomerController::class, 'create'])->middleware('auth')->name('Customer.create');
Route::post('/admin/loyalty/customer/create', [CustomerController::class, 'store'])->middleware('auth')->name('Customer.store');
Route::get('/admin/loyalty/customer/edit/{id}', [CustomerController::class, 'edit'])->middleware('auth')->name('Customer.edit');
Route::put('/admin/loyalty/customer/edit/{id}', [CustomerController::class, 'update'])->middleware('auth')->name('Customer.update');
Route::delete('/admin/loyalty/customer/{id}', [CustomerController::class, 'destroy'])->middleware('auth')->name('Customer.destroy');
Route::get('/admin/loyalty/customer/{id}', [CustomerController::class, 'show'])->middleware('auth')->name('Customer.show');

// Setting Routes
// Route::get('/admin/loyalty/settings', [LoyaltySettingController::class, 'index'])->name('Setting.index');
Route::get('/admin/loyalty/settings', [LoyaltySettingController::class, 'create'])->name('Setting.create');
Route::post('/admin/loyalty/settings/create', [LoyaltySettingController::class, 'store'])->name('Setting.store');
Route::get('/admin/loyalty/settings/edit/{client_id}', [LoyaltySettingController::class, 'edit'])->name('Setting.edit');
Route::put('/admin/loyalty/settings/edit/{client_id}', [LoyaltySettingController::class, 'update'])->name('Setting.update');
Route::delete('/admin/loyalty/settings/edit/{id}', [LoyaltySettingController::class, 'delete'])->name('Setting.delete');

