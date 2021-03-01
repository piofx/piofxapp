<?php

use App\Http\Controllers\UserManagement\UserManagerController;

Route::get('/user', [UserManagerController::class, 'index'])->name('UserManager.index');
Route::get('/user/create', [UserManagerController::class, 'create'])->name('UserManager.create');
Route::post('/user/create', [UserManagerController::class, 'store'])->name('UserManager.store');
Route::get('/user/edit/{id}', [UserManagerController::class, 'edit'])->name('UserManager.edit');
Route::put('/user/update/{id}', [UserManagerController::class, 'update'])->name('UserManager.update');
Route::delete('/user/delete/{id}', [UserManagerController::class, 'destroy'])->name('UserManager.destroy');
Route::get('/user/{id}', [UserManagerController::class, 'show'])->name('UserManager.show');

