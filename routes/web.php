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
    /**
     * Tags
     */
    Route::get('/user/{user_id}/tags', 'TagController@indexFor')->name('tag.indexFor');
    Route::post('/user/{user_id}/tag', 'TagController@store')->name('tag.store');
    Route::get('/tags', 'TagController@index')->name('tags');

    /**
     * Tasks
     */
    Route::get('/user/{user_id}/tasks', 'TaskController@indexForUser')->name('tasks.index');
    Route::post('/user/{user_id}/task', 'TaskController@store')->name('task.store');
    Route::patch('/user/{user_id}/task/{task}', 'TaskController@update')->name('task.update');
    Route::delete('/user/{user_id}/task/{task_id}', 'TaskController@delete')->name('task.delete');

    /**
     * Subtasks
     */
    Route::get('/user/{user_id}/task/{task_id}/subtasks', 'SubtaskController@indexForTask')->name('subtasks.index');
    Route::post('/user/{user_id}/task/{task_id}/subtask', 'SubtaskController@store')->name('subtask.store');
    Route::patch('/user/{user_id}/task/{task_id}/subtask/{subtask}', 'SubtaskController@update')->name('subtask.update');
    Route::delete('/user/{user_id}/task/{task_id}/subtask/{subtask}', 'SubtaskController@delete')->name('subtask.delete');
});

Route::get('/home', 'HomeController@index')->name('home');


