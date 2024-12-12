<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    Auth:loginUsingId(1);

    return to_route('dashboard');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/email-list', [EmailListController::class, 'index'])->name('email-list.index');

    Route::get('/email-list/create', [EmailListController::class, 'create'])->name('email-list.create');
    Route::post('/email-list/create', [EmailListController::class, 'store']);

    Route::get('/email-list/{emailsList}/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');

    Route::get('/email-list/{emailsList}/subscribers/create', [SubscriberController::class, 'create'])->name('subscribers.create');
    Route::post('/email-list/{emailsList}/subscribers/create', [SubscriberController::class, 'store']);

    Route::delete('/email-list/{emailsList}/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    Route::resource('templates', TemplateController::class);
    Route::resource('campaigns', CampaignController::class)->only(['index', 'create', 'destroy']);
});

require __DIR__.'/auth.php';
