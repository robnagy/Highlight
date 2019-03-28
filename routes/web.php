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

Route::get('/login/guest', 'Auth\LoginController@guestLogin')->name('auth.guestLogin');

Route::group(['middleware' => ['web']], function () {
    /**
     * Tags
     */
    Route::get('/user/{user_id}/tags', 'TagController@indexFor')->name('tag.indexFor');
    Route::post('/user/{user_id}/tag', 'TagController@store')->name('tag.store');
    Route::get('/tags', 'TagController@index')->name('tags');
    Route::get('/user/{user_id}/task/{task_id}/tags', 'TagTaskController@index')->name('tagTask.index');
    Route::get('/user/{user_id}/task/{task_id}/tag/{tag_id}/link', 'TagTaskController@link')->name('tagTask.link');
    Route::get('/user/{user_id}/task/{task_id}/tag/{tag_id}/unlink', 'TagTaskController@unlink')->name('tagTask.unlink');

    /**
     * Tasks
     */
    Route::get('/user/{user_id}/tasks/{date?}', 'TaskController@indexForUser')
        ->name('tasks.index');
    Route::post('/user/{user_id}/task', 'TaskController@store')
        ->name('task.store');
    Route::patch('/user/{user_id}/task/{task_id}', 'TaskController@update')
        ->name('task.update');
    Route::delete('/user/{user_id}/task/{task_id}', 'TaskController@delete')
        ->name('task.delete');

    /**
     * Subtasks
     */
    Route::get('/user/{user_id}/task/{task_id}/subtasks', 'SubtaskController@indexForTask')->name('subtasks.index');
    Route::post('/user/{user_id}/task/{task_id}/subtask', 'SubtaskController@store')->name('subtask.store');
    Route::patch('/user/{user_id}/task/{task_id}/subtask/{subtask_id}', 'SubtaskController@update')->name('subtask.update');
    Route::delete('/user/{user_id}/task/{task_id}/subtask/{subtask_id}', 'SubtaskController@delete')->name('subtask.delete');
});

Route::get('/home', 'HomeController@index')->name('home');


