<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/notes/','NotesController@index');

Route::get('/notes/create/','NotesController@create');

Route::get('/notes/show/{id}','NotesController@show');

Route::get('/notes/delete/{id}','NotesController@delete');

Route::get('/notes/edit/{id}','NotesController@edit');

Route::post('/notes/','NotesController@store');

Route::post('/notes/edit/','NotesController@update');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/logout/', 'UserController@logout');
