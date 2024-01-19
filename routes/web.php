<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//Routes for VueJs
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '^(?!api).*$');
