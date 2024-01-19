<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PluckController;
use App\Http\Controllers\StateController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::put('/settings', [AuthController::class, 'settings'])->middleware('auth:api');
Route::put('/notes', [NoteController::class, 'notes'])->middleware('auth:api');
Route::get('/state', [StateController::class, 'index']);//TODO: ->middleware('auth:api');
Route::get('/pluck', [PluckController::class, 'index'])->middleware('auth:api');
