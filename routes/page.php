<?php
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Page\ModuleController;
use App\Http\Controllers\Page\ThemeController;
use App\Http\Controllers\Page\AssetController;


/* Theme routes */
Route::get('/admin/theme', [ThemeController::class, 'index'])
		->middleware(['auth'])->name('Theme.index');
Route::get('/admin/theme/create', [ThemeController::class, 'create'])
		->middleware(['auth'])->name('Theme.create');
Route::get('/admin/theme/{theme}/edit', [ThemeController::class, 'edit'])
		->middleware(['auth'])->name('Theme.edit');
Route::post('/admin/theme', [ThemeController::class, 'store'])
		->middleware(['auth'])->name('Theme.store');
Route::post('/admin/theme/upload', [ThemeController::class, 'upload'])
		->middleware(['auth'])->name('Theme.upload');
Route::get('/admin/theme/library', [ThemeController::class, 'library'])
		->middleware(['auth'])->name('Theme.library');
Route::put('/admin/theme/{theme}', [ThemeController::class, 'update'])
		->middleware(['auth'])->name('Theme.update');
Route::delete('/admin/theme/{theme}', [ThemeController::class, 'destroy'])
		->middleware(['auth'])->name('Theme.destroy');
Route::post('/admin/theme/{theme}', [ThemeController::class, 'show'])
		->middleware(['auth'])->name('Theme.show');
Route::get('/admin/theme/{theme}', [ThemeController::class, 'show'])
		->middleware(['auth'])->name('Theme.show');
Route::get('/admin/theme/{theme}/preview', [ThemeController::class, 'preview'])
		->middleware(['auth'])->name('Theme.page');
Route::post('/admin/theme/{theme}/download', [ThemeController::class, 'download'])
		->middleware(['auth'])->name('Theme.download');


/* Asset routes */
Route::get('/admin/theme/{theme}/asset', [AssetController::class, 'index'])
		->middleware(['auth'])->name('Asset.index');
Route::get('/admin/theme/{theme}/asset/create', [AssetController::class, 'create'])
		->middleware(['auth'])->name('Asset.create');
Route::get('/admin/theme/{theme}/asset/{asset}/edit', [AssetController::class, 'edit'])
		->middleware(['auth'])->name('Asset.edit');
Route::post('/admin/theme/{theme}/asset', [AssetController::class, 'store'])
		->middleware(['auth'])->name('Asset.store');
Route::put('/admin/theme/{theme}/asset/{asset}', [AssetController::class, 'update'])
		->middleware(['auth'])->name('Asset.update');
Route::delete('/admin/theme/{theme}/asset/{asset}', [AssetController::class, 'destroy'])
		->middleware(['auth'])->name('Asset.destroy');
Route::get('/admin/theme/{theme}/asset/{asset}', [AssetController::class, 'show'])
		->middleware(['auth'])->name('Asset.show');

/* Module routes */
Route::get('/admin/theme/{theme}/module', [ModuleController::class, 'index'])
		->middleware(['auth'])->name('Module.index');
Route::get('/admin/theme/{theme}/module/create', [ModuleController::class, 'create'])
		->middleware(['auth'])->name('Module.create');
Route::get('/admin/theme/{theme}/module/{module}/edit', [ModuleController::class, 'edit'])
		->middleware(['auth'])->name('Module.edit');
Route::post('/admin/theme/{theme}/module/{module}', [ModuleController::class, 'show'])
		->middleware(['auth'])->name('Module.save');
Route::post('/admin/theme/{theme}/module', [ModuleController::class, 'store'])
		->middleware(['auth'])->name('Module.store');
Route::put('/admin/theme/{theme}/module/{module}', [ModuleController::class, 'update'])
		->middleware(['auth'])->name('Module.update');
Route::delete('/admin/theme/{theme}/module/{module}', [ModuleController::class, 'destroy'])
		->middleware(['auth'])->name('Module.destroy');
Route::get('/admin/theme/{theme}/module/{module}', [ModuleController::class, 'show'])
		->middleware(['auth'])->name('Module.show');

/* Page routes */
Route::get('/admin/theme/{theme}/page', [PageController::class, 'index'])
		->middleware(['auth'])->name('Page.index');
Route::get('/admin/theme/{theme}/page/create', [PageController::class, 'create'])
		->middleware(['auth'])->name('Page.create');
Route::get('/admin/theme/{theme}/page/{page}/edit', [PageController::class, 'edit'])
		->middleware(['auth'])->name('Page.edit');
Route::post('/admin/theme/{theme}/page', [PageController::class, 'store'])
		->middleware(['auth'])->name('Page.store');
Route::put('/admin/theme/{theme}/page/{page}', [PageController::class, 'update'])
		->middleware(['auth'])->name('Page.update');
Route::delete('/admin/theme/{theme}/page/{page}', [PageController::class, 'destroy'])
		->middleware(['auth'])->name('Page.destroy');
Route::get('/admin/theme/{theme}/previewpage/{page}', [PageController::class, 'theme'])
		->middleware(['auth'])->name('Page.theme');
Route::post('/admin/theme/{theme}/page/{page}', [PageController::class, 'show'])
		->middleware(['auth'])->name('Page.save');
Route::get('/admin/theme/{theme}/page/{page}', [PageController::class, 'show'])
		->middleware(['auth'])->name('Page.show');



Route::get('/{page}', [PageController::class, 'public'])->name('Page.public');
Route::get('/{page}/{u1}', [PageController::class, 'public'])->name('Page.public');
Route::get('/{page}/{u1}/{u2}', [PageController::class, 'public'])->name('Page.public');
Route::get('/{page}/{u1}/{u2}/{u3}', [PageController::class, 'public'])->name('Page.public');

