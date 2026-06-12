<?php

use App\Http\Controllers\ResourceManager\ResourceController;

Route::get('file', [ResourceController::class, 'index'])->name('Resource.index');
Route::get('file/create', [ResourceController::class, 'create'])->name('Resource.create');
Route::post('file/create', [ResourceController::class, 'store'])->name('Resource.store');
Route::get('file/{id}/edit', [ResourceController::class, 'edit'])->name('Resource.edit');
Route::put('file/{id}', [ResourceController::class, 'update'])->name('Resource.update');
Route::delete('file/delete/{id}', [ResourceController::class, 'destroy'])->name('Resource.destroy');
Route::get('file/{filename}', [ResourceController::class, 'show'])->name('Resource.show');
Route::get('file/download/{file}', [ResourceController::class, 'download'])->name('Resource.download');
Route::group(['prefix' => 'files'], function (){
    \UniSharp\LaravelFilemanager\Lfm::routes();
});



