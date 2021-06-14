<?php

use App\Http\Controllers\Mailer\MailSubscriberController;
use App\Http\Controllers\Mailer\MailTemplateController;
use App\Http\Controllers\Mailer\MailCampaignController;
use App\Http\Controllers\Mailer\MailLogController;

// MailSubscriber routes

Route::get("/admin/mailsubscribers", [MailSubscriberController::class, "index"])->middleware('auth')->name("MailSubscriber.index");
Route::get("/admin/mailsubscriber/create", [MailSubscriberController::class, "create"])->middleware('auth')->name("MailSubscriber.create");
Route::post("/admin/mailsubscriber/create", [MailSubscriberController::class, "store"])->middleware('auth')->name("MailSubscriber.store");
Route::get("/admin/mailsubscriber/{slug}/edit", [MailSubscriberController::class, "edit"])->middleware('auth')->name("MailSubscriber.edit");
Route::put("/admin/mailsubscriber/{id}", [MailSubscriberController::class, "update"])->middleware('auth')->name("MailSubscriber.update");
Route::get("/admin/mailsubscriber/samplecsv", [MailSubscriberController::class, "samplecsv"])->middleware('auth')->name("MailSubscriber.samplecsv");
Route::get("/admin/mailsubscriber/download", [MailSubscriberController::class, "download"])->middleware('auth')->name("MailSubscriber.download");
Route::delete("/admin/mailsubscriber/{id}", [MailSubscriberController::class, "destroy"])->middleware('auth')->name("MailSubscriber.destroy");
Route::get("/admin/mailsubscriber/{slug}", [MailSubscriberController::class, "show"])->middleware('auth')->name("MailSubscriber.show");
Route::post("/admin/mailsubscriber/upload", [MailSubscriberController::class, "upload"])->middleware('auth')->name("MailSubscriber.upload");

// MailTemplate routes

Route::get("/admin/mailtemplates", [MailTemplateController::class, "index"])->middleware('auth')->name("MailTemplate.index");
Route::get("/admin/mailtemplate/create", [MailTemplateController::class, "create"])->middleware('auth')->name("MailTemplate.create");
Route::post("/admin/mailtemplate/create", [MailTemplateController::class, "store"])->middleware('auth')->name("MailTemplate.store");
Route::get("/admin/mailtemplate/{slug}/edit", [MailTemplateController::class, "edit"])->middleware('auth')->name("MailTemplate.edit");
Route::put("/admin/mailtemplate/{id}", [MailTemplateController::class, "update"])->middleware('auth')->name("MailTemplate.update");
Route::delete("/admin/mailtemplate/{id}", [MailTemplateController::class, "destroy"])->middleware('auth')->name("MailTemplate.destroy");
Route::get("/admin/mailtemplate/{slug}", [MailTemplateController::class, "show"])->middleware('auth')->name("MailTemplate.show");

// MailCampaign routes

Route::get("/admin/mailcampaigns", [MailCampaignController::class, "index"])->middleware('auth')->name("MailCampaign.index");
Route::get("/admin/mailcampaign/create", [MailCampaignController::class, "create"])->middleware('auth')->name("MailCampaign.create");
Route::post("/admin/mailcampaign/create", [MailCampaignController::class, "store"])->middleware('auth')->name("MailCampaign.store");
Route::get("/admin/mailcampaign/resendmails/{id}", [MailCampaignController::class, "resendmails"])->middleware('auth')->name("MailCampaign.resendmails");
Route::get("/admin/mailcampaign/{slug}/edit", [MailCampaignController::class, "edit"])->middleware('auth')->name("MailCampaign.edit");
Route::put("/admin/mailcampaign/{id}", [MailCampaignController::class, "update"])->middleware('auth')->name("MailCampaign.update");
Route::delete("/admin/mailcampaign/{id}", [MailCampaignController::class, "destroy"])->middleware('auth')->name("MailCampaign.destroy");
Route::get("/admin/mailcampaign/{slug}", [MailCampaignController::class, "show"])->middleware('auth')->name("MailCampaign.show");

// MailLog routes

Route::get("/admin/maillogs", [MailLogController::class, "index"])->middleware('auth')->name("MailLog.index");
Route::delete("/admin/maillog/{id}", [MailLogController::class, "destroy"])->middleware('auth')->name("MailLog.destroy");


