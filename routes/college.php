<?php

use App\Http\Controllers\College\CollegeController;


/* College routes */
Route::get('/admin/college', [CollegeController::class, 'index'])
		->middleware(['auth'])->name('College.index');
Route::get('/admin/college/{college}/edit', [CollegeController::class, 'edit'])
		->middleware(['auth'])->name('College.edit');
Route::get('/admin/college/upload', [CollegeController::class, 'upload'])
		->middleware(['auth'])->name('College.upload');
Route::post('/admin/college/upload', [CollegeController::class, 'upload'])
		->middleware(['auth'])->name('College.upload');
Route::get('/admin/college/create', [CollegeController::class, 'create'])
		->middleware(['auth'])->name('College.create');
Route::post('/admin/college', [CollegeController::class, 'store'])
		->middleware(['cors'])
		->name('College.store');		
Route::put('/admin/college/{college}', [CollegeController::class, 'update'])
		->middleware(['auth'])->name('College.update');
Route::delete('/admin/college/{college}', [CollegeController::class, 'destroy'])
		->middleware(['auth'])->name('College.destroy');
Route::get('/admin/college/{college}', [CollegeController::class, 'show'])
		->middleware(['auth'])->name('College.show');





