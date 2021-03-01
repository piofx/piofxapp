<?php


use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\AgencyController;
use App\Http\Controllers\Core\ClientController;
use App\Http\Controllers\Core\ContactController;
use App\Http\Controllers\Core\UserController;

/* Admin routes */
Route::get('/admin', [AdminController::class, 'index'])
		->middleware(['auth'])->name('dashboard');
Route::get('/admin/apps', [AdminController::class, 'apps'])
		->middleware(['auth'])->name('apps');


/* Agency routes */
Route::get('/admin/agency', [AgencyController::class, 'index'])
		->middleware(['auth'])->name('Agency.index');
Route::get('/admin/agency/create', [AgencyController::class, 'create'])
		->middleware(['auth'])->name('Agency.create');
Route::get('/admin/agency/{agency}', [AgencyController::class, 'show'])
		->middleware(['auth'])->name('Agency.show');
Route::get('/admin/agency/{agency}/edit', [AgencyController::class, 'edit'])
		->middleware(['auth'])->name('Agency.edit');
Route::post('/admin/agency', [AgencyController::class, 'store'])
		->middleware(['auth'])->name('Agency.store');
Route::put('/admin/agency/{agency}', [AgencyController::class, 'update'])
		->middleware(['auth'])->name('Agency.update');
Route::delete('/admin/agency/{agency}', [AgencyController::class, 'destroy'])
		->middleware(['auth'])->name('Agency.destroy');

/* client routes */

Route::get('/admin/client', [ClientController::class, 'index'])
		->middleware(['auth'])->name('Client.index');
Route::get('/admin/client/create', [ClientController::class, 'create'])
		->middleware(['auth'])->name('Client.create');
Route::get('/admin/client/{client}', [ClientController::class, 'show'])
		->middleware(['auth'])->name('Client.show');
Route::get('/admin/client/{client}/edit', [ClientController::class, 'edit'])
		->middleware(['auth'])->name('Client.edit');
Route::post('/admin/client', [ClientController::class, 'store'])
		->middleware(['auth'])->name('Client.store');
Route::put('/admin/client/{client}', [ClientController::class, 'update'])
		->middleware(['auth'])->name('Client.update');
Route::delete('/admin/client/{client}', [ClientController::class, 'destroy'])
		->middleware(['auth'])->name('Client.destroy');
Route::get('/admin/settings', [ClientController::class, 'edit'])
		->middleware(['auth'])->name('Client.settings');


/* Contacts routes */

Route::get('/contact', [ContactController::class, 'create'])
		->name('Contact.create');

Route::get('/admin/contact', [ContactController::class, 'index'])
		->middleware(['auth'])->name('Contact.index');
Route::get('/admin/contact/{contact}/edit', [ContactController::class, 'edit'])
		->middleware(['auth'])->name('Contact.edit');
Route::post('/admin/contact', [ContactController::class, 'store'])
		->middleware(['auth'])->name('Contact.store');
Route::put('/admin/contact/{contact}', [ContactController::class, 'update'])
		->middleware(['auth'])->name('Contact.update');
Route::delete('/admin/contact/{contact}', [ContactController::class, 'destroy'])
		->middleware(['auth'])->name('Contact.destroy');
Route::get('/admin/contact/{contact}', [ContactController::class, 'show'])
		->middleware(['auth'])->name('Contact.show');



/* User routes */

Route::get('/admin/user/create', [UserController::class, 'create'])
		->name('User.create');
Route::get('/admin/user', [UserController::class, 'index'])
		->middleware(['auth'])->name('User.index');
Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])
		->middleware(['auth'])->name('User.edit');
Route::post('/admin/user', [UserController::class, 'store'])
		->middleware(['auth'])->name('User.store');
Route::put('/admin/user/{user}', [UserController::class, 'update'])
		->middleware(['auth'])->name('User.update');
Route::delete('/admin/user/{user}', [UserController::class, 'destroy'])
		->middleware(['auth'])->name('User.destroy');
Route::get('/admin/user/{user}', [UserController::class, 'show'])
		->middleware(['auth'])->name('User.show');









