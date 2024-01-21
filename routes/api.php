<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TabController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::put('/settings', [AuthController::class, 'settings'])->middleware('auth:api');
Route::get('/state', [StateController::class, 'index']);//TODO: ->middleware('auth:api');
Route::resource('tabs', TabController::class)->middleware('auth:api');
Route::resource('notes', NoteController::class)->middleware('auth:api');
