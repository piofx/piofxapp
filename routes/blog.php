<?php

use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Blog\TagController;
use App\Http\Controllers\Blog\BlogSettingsController;

Route::get("/admin/blog/addContent", [PostController::class, 'addContent'])->middleware('auth');
Route::get("/admin/blog/getContent", [PostController::class, 'getContent'])->middleware('auth');
Route::get("/admin/blog/changeContent", [PostController::class, 'changeContent'])->middleware('auth');

// Settings
Route::get("/admin/blog/settings", [BlogSettingsController::class, 'index'])->middleware('auth')->name("Settings.index");
Route::get("/admin/blog/settings/edit", [BlogSettingsController::class, 'edit'])->middleware('auth')->name("Settings.edit");
Route::put("/admin/blog/settings/update", [BlogSettingsController::class, 'update'])->middleware('auth')->name("Settings.update");

// Category Routes
Route::get("/admin/blog/categories", [CategoryController::class, "index"])->middleware('auth')->name("Category.index");
Route::get("/admin/blog/category/create", [CategoryController::class, "create"])->middleware("auth")->name("Category.create");
Route::post("/admin/blog/category/create", [CategoryController::class, "store"])->middleware("auth")->name("Category.store");
Route::get("/admin/blog/category/{slug}/edit", [CategoryController::class, "edit"])->middleware("auth")->name("Category.edit");
Route::put("/admin/blog/category/{id}", [CategoryController::class, "update"])->middleware("auth")->name("Category.update");
Route::delete("/admin/blog/category/{id}", [CategoryController::class, "destroy"])->middleware("auth")->name("Category.destroy");
Route::get("/blog/category/{slug}", [CategoryController::class, "show"])->name("Category.show");


// Tag Routes
Route::get("/admin/blog/tags", [TagController::class, "index"])->middleware('auth')->name("Tag.index");
Route::get("/admin/blog/tag/create", [TagController::class, "create"])->middleware("auth")->name("Tag.create");
Route::post("/admin/blog/tag/create", [TagController::class, "store"])->middleware("auth")->name("Tag.store");
Route::get("/admin/blog/tag/{slug}/edit", [TagController::class, "edit"])->middleware("auth")->name("Tag.edit");
Route::put("/admin/blog/tag/{id}", [TagController::class, "update"])->middleware("auth")->name("Tag.update");
Route::delete("/admin/blog/tag/{id}", [TagController::class, "destroy"])->middleware("auth")->name("Tag.destroy");
Route::get("/blog/tag/{slug}", [TagController::class, "show"])->name("Tag.show");

// Post Routes
// Route::get("/admin/blog/content", [PostController::class, "addContent"]);
Route::get("/admin/blog/searchConsole", [PostController::class, "searchConsole"])->name("Post.searchConsole");
Route::get("/admin/blog/testResult", [PostController::class, "testResult"]);
Route::get("/blog", [PostController::class, "index"])->name("Post.index");
Route::get("/admin/blog", [PostController::class, "list"])->middleware("auth")->name("Post.list");
Route::get("/admin/blog/create", [PostController::class, "create"])->middleware("auth")->name("Post.create");
Route::post("/admin/blog/create", [PostController::class, "store"])->middleware("auth")->name("Post.store");
Route::get("/blog/search", [PostController::class, "search"])->name("Post.search");
Route::get("/admin/blog/{slug}/edit", [PostController::class, "edit"])->middleware("auth")->name("Post.edit");
Route::put("/admin/blog/{id}", [PostController::class, "update"])->middleware("auth")->name("Post.update");
Route::delete("/admin/blog/{id}/delete", [PostController::class, "destroy"])->middleware("auth")->name("Post.destroy");
Route::get("/blog/author/{name}", [PostController::class, "author"])->name("Post.author");
Route::get("/blog/{slug}", [PostController::class, "show"])->name("Post.show");

// Retrieve popular post
Route::get("/popularPost", [PostController::class, "popularPost"])->name("Post.popular");
Route::post("/blog/subscribe", [PostController::class, "subscribe"])->name("Post.subscribe");
Route::get("/blog/{slug}", [PostController::class, "show"])->name("Post.show");
