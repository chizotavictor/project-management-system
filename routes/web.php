<?php

use Illuminate\Support\Facades\Route;

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
    if(!\Auth::check()) {
        return view('auth.login');
    }else {
        return redirect()->route('home');
    }
})->name('welcome');

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@logout')->name('logout');

    Route::prefix('office')->group(function () {
        Route::get('/', function() {
            return redirect()->route('home');
        });
        Route::get('/tasks', 'TaskController@userAssignedTasks')->name('user.task');
        Route::get('/task/{status}', 'TaskController@userAssignedTasksByStatus')->name('user.task.status');
        Route::get('/tasks/{task_id}', 'TaskController@viewUserAssignedTask')->name('user.taskitem');
        Route::post('/tasks/start', 'TaskController@startAssignedTask')->name('task.start');
        Route::get('/subtasks', 'TaskController@userAssignedSubTasks')->name('user.substask');
        Route::get('/subtasks/{subtask_id}', 'TaskController@viewUserAssignedSubTask')->name('user.subtaskitem');
        Route::post('/subtask/start', 'TaskController@startSubAssignedTask')->name('subtask.start');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function() {
        Route::get('/', function() {
            return redirect()->route('home');
        });
        Route::get('/tasks', 'TaskController@index')->name('task');
        Route::get('/tasks/add', 'TaskController@createTask')->name('task.add');
        Route::post('/tasks/add', 'TaskController@createNewTask')->name('task.add.submit');
        
        Route::get('/tasks/{task_id}', 'TaskController@addNewTaskItem')->name('taskitem');
        Route::get('/tasks/{task_id}/add', 'TaskController@addTaskItem')->name('taskitem.add');
        Route::post('/tasks/{task_id}/add', 'TaskController@createNewTaskItem')->name('taskitem.add.submit');

        Route::get('/staff', 'StaffController@index')->name('staff');
        Route::get('/staff/add', 'StaffController@addNewUser')->name('staff.add');
        Route::post('/staff/add', 'StaffController@createNewUser')->name('staff.add.submit');
    });
});

