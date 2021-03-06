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
        Route::post('/tasks/item-submit', 'TaskController@submitTaskItem')->name('submit-task');
        Route::post('/tasks/task-submit', 'TaskController@submitTask')->name('user.submit-task');
        Route::post('/tasks/start', 'TaskController@startAssignedTask')->name('task.start');
        Route::get('/subtasks', 'TaskController@userAssignedSubTasks')->name('user.substask');
        Route::get('/subtasks/{subtask_id}', 'TaskController@viewUserAssignedSubTask')->name('user.subtaskitem');
        Route::post('/subtask/start', 'TaskController@startSubAssignedTask')->name('subtask.start');

        Route::get('/tasks/task-item/issues', 'TaskController@viewUserAllIssues')->name('user.all-issues');
        Route::get('/tasks/task-item/issues/{task_item_id}/detail', 'TaskController@viewTaskIssueDetail')->name('user.issue-detail');
        Route::get('/tasks/task-item/{item_id}/issues', 'TaskController@viewUserTaskItemIssues')->name('user.issues');
        Route::post('/tasks/task-item/issues/closed', 'TaskController@closeIssue')->name('user.issue.close');
        Route::post('/tasks/task-item/issues/resolve', 'TaskController@resolveIssue')->name('user.issue.resolve');
    });

    Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function() {
        Route::get('/', function() {
            return redirect()->route('home');
        });
        Route::get('/tasks', 'TaskController@index')->name('task');
        Route::get('/tasks/add', 'TaskController@createTask')->name('task.add');
        Route::post('/tasks/add', 'TaskController@createNewTask')->name('task.add.submit');
        Route::get('/tasks/{task_id}/edit', 'TaskController@editTask')->name('task.edit');
        Route::post('/tasks/edit', 'TaskController@updateTask')->name('task.update');
        Route::post('/tasks/delete', 'TaskController@deleteTask')->name('task.delete');

        Route::get('/tasks/{task_id}', 'TaskController@addNewTaskItem')->name('taskitem');
        Route::get('/tasks/{task_id}/add', 'TaskController@addTaskItem')->name('taskitem.add');
        Route::post('/tasks/{task_id}/add', 'TaskController@createNewTaskItem')->name('taskitem.add.submit');
        Route::get('/tasks/{task_id}/{item_id}/edit', 'TaskController@editTaskItem')->name('taskitem.edit');
        Route::post('/task-item/update', 'TaskController@updateTaskItem')->name('taskitem.update');
        Route::post('/task-item/delete', 'TaskController@deleteTaskItem')->name('taskitem.delete');

        Route::get('/audit-task-item', 'TaskController@alterTaskItemStatus')->name('submit-task-item');
        Route::get('/audit-task', 'TaskController@alterTaskStatus')->name('submit-task');

        Route::get('/staff', 'StaffController@index')->name('staff');
        Route::get('/staff/add', 'StaffController@addNewUser')->name('staff.add');
        Route::post('/staff/add', 'StaffController@createNewUser')->name('staff.add.submit');
        Route::get('/staff/{user_id}/edit', 'StaffController@editUser')->name('staff.edit');
        Route::post('/staff/update', 'StaffController@updateUser')->name('staff.update');
        Route::post('/staff/delete', 'StaffController@deleteUser')->name('staff.delete');

        Route::get('/tasks/task-item/{task_id}/{item_id}/issues', 'TaskController@allIssues')->name('issues');
        Route::get('/tasks/task-item/{item_id}/issues/add', 'TaskController@addIssue')->name('issue.add');
        Route::get('/tasks/task-item/issues/{issue_id}/edit', 'TaskController@editIssue')->name('issue.edit');
        Route::post('/tasks/task-item/issues/update', 'TaskController@updateIssue')->name('issue.update');
        Route::post('/tasks/task-item/issues/add', 'TaskController@createNewIssue')->name('issue.create');

    });
});


