<?php

use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {

    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('groups/store', [GroupController::class, 'store'])->name('groups.store');

    Route::get('/chat/{group}', [App\Http\Controllers\ChatsController::class, 'index']);
    Route::get('/messages/{group}', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
    Route::post('/messages/{groupId}', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
