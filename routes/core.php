<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\AgencyController;
use App\Http\Controllers\Core\ClientController;
use App\Http\Controllers\Core\ContactController;
use App\Http\Controllers\Core\UserController;
use App\Http\Controllers\Core\StatisticsController;

/* Admin routes */
Route::get('/admin', [AdminController::class, 'index'])
		->middleware(['auth'])->name('dashboard');
Route::get('/admin/tracker', [AdminController::class, 'tracker'])
		->middleware(['auth'])->name('tracker');
Route::post('/admin/tracker', [AdminController::class, 'tracker'])
		->middleware(['auth'])->name('tracker');
Route::get('/admin/tracker/user/{user}', [AdminController::class, 'user'])
		->middleware(['auth'])->name('user.tracker');
Route::get('/admin/apps', [AdminController::class, 'apps'])
		->middleware(['auth'])->name('apps');
//sample email
Route::get('/admin/email', [AdminController::class, 'sampletestemail'])
		->middleware(['auth']);

// Settings Routes
Route::get('/admin/gsettings', [AdminController::class, 'gsettings'])
		->middleware(['auth'])->name('gsettings');
Route::post('/admin/gsettings', [AdminController::class, 'gsettings'])
		->middleware(['auth'])->name('gsettings');

/* dropzone uploader demo */
Route::get('/admin/dropzone', [AdminController::class, 'dropzone'])
		->middleware(['auth'])->name('admin.dropzone');
Route::post('/admin/dropzone', [AdminController::class, 'dropzone'])
		->middleware(['auth'])->name('admin.dropzone');


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
Route::get('/contact/api', [ContactController::class, 'api'])
		->name('Contact.api');
Route::get('/contact/otp', [ContactController::class, 'otp'])
		->name('Contact.otp');
Route::get('/admin/contact', [ContactController::class, 'index'])
		->middleware(['auth'])->name('Contact.index');
Route::get('/admin/contact/{contact}/edit', [ContactController::class, 'edit'])
		->middleware(['auth'])->name('Contact.edit');
Route::get('/admin/contact/settings', [ContactController::class, 'settings'])
		->middleware(['auth'])->name('Contact.settings');
Route::post('/admin/contact/settings', [ContactController::class, 'settings'])
		->middleware(['auth'])->name('Contact.settings');
Route::post('/admin/contact', [ContactController::class, 'store'])
		->name('Contact.store');		
Route::put('/admin/contact/{contact}', [ContactController::class, 'update'])
		->middleware(['auth'])->name('Contact.update');
Route::delete('/admin/contact/{contact}', [ContactController::class, 'destroy'])
		->middleware(['auth'])->name('Contact.destroy');
Route::get('/admin/contact/{contact}', [ContactController::class, 'show'])
		->middleware(['auth'])->name('Contact.show');


/* User routes */

Route::get('/admin/user', [UserController::class, 'index'])
		->middleware(['auth'])->name('User.index');
Route::get('admin/users/search',[UserController::class, 'search'])
        ->middleware(['auth'])->name('User.search');
Route::get('/admin/user/create', [UserController::class, 'create'])
        ->middleware(['auth'])->name('User.create');
Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])
		->middleware(['auth'])->name('User.edit');
Route::get('/admin/user/settings', [UserController::class, 'settings'])
		->middleware(['auth'])->name('User.settings');
Route::post('/admin/user/settings', [UserController::class, 'settings'])
		->middleware(['auth'])->name('User.settings');
Route::post('/admin/user', [UserController::class, 'store'])
		->middleware(['auth'])->name('User.store');
Route::get('/admin/user/download', [UserController::class, 'download'])
		->middleware(['auth'])->name('User.download');
Route::get('/admin/user/samplecsv', [UserController::class, 'samplecsv'])
		->middleware(['auth'])->name('User.samplecsv');
Route::post('/admin/user/upload', [UserController::class, 'upload'])
		->middleware(['auth'])->name('User.upload');
Route::get('/admin/user/statistics', [UserController::class, 'statistics'])
		->middleware(['auth'])->name('User.statistics');
Route::put('/admin/user/{user}', [UserController::class, 'update'])
		->middleware(['auth'])->name('User.update');
Route::get('/admin/user/{id}/resetpassword', [UserController::class, 'resetpassword'])
		->middleware(['auth'])->name('User.resetpassword');
Route::delete('/admin/user/{user}', [UserController::class, 'destroy'])
		->middleware(['auth'])->name('User.destroy');
Route::get('/admin/user/{id}', [UserController::class, 'show'])
		->middleware(['auth'])->name('User.show');

/* User API Routes*/		
Route::post('/user/apilogin', [UserController::class, 'api_login'])->name('User.apilogin');
Route::get('/user/apilogin', [UserController::class, 'api_login'])->name('User.apilogin');
Route::get('/user/apiuser', [UserController::class, 'api_user'])->name('User.apiuser');
Route::post('/user/apiregister', [UserController::class, 'api_register'])->name('User.apiregister');

/* User Profile Routes*/ 
Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
Route::get('/profile/{user}/edit', [UserController::class, 'profile_edit'])->name('profile.edit');
Route::put('/profile/{user}/', [UserController::class, 'profile_update'])->name('profile.update');
Route::get('/profile/{user}/', [UserController::class, 'profile_show'])->name('profile.show');


// Statistic Routes
Route::get('/admin/statistics', [StatisticsController::class, 'index'])
		->middleware(['auth'])->name('Statistics.index');








