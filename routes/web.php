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


Auth::routes();

Route::group(['middleware' => ['web']], function () {
    Route::get('/user/{user_id}/tags', 'TagController@indexFor')->name('tag.indexFor');
    Route::post('/user/{user_id}/tag', 'TagController@store')->name('tag.store');
    Route::get('/user/{user_id}/tasks', 'TaskController@indexForUser')->name('tasks.index');
    Route::post('/user/{user_id}/task', 'TaskController@store')->name('task.store');
    Route::patch('/user/{user_id}/task/{task}', 'TaskController@update')->name('tasks.update');
    Route::get('/tags', 'TagController@index')->name('tags');
});

Route::get('/home', 'HomeController@index')->name('home');


