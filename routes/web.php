<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks', function () {
   return view('tasks')->with('userId', 1);
})->name('tasks');

Route::get('/user/{userID}/tasks', 'TaskController@indexForUser')->name('tasksForUser');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tags', 'TagController@index')->name('tags');
