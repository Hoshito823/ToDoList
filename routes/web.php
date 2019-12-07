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

Route::group(['middleware' => 'auth'], function () {
    Route::get('todolist/create', 'Admin\TasksController@add');
    Route::post('todolist/create','Admin\TasksController@create');
    Route::get('todolist','Admin\TasksController@index');
    Route::get('todolist/edit','Admin\TasksController@edit');
    Route::post('todolist/edit', 'Admin\TasksController@update');
    Route::get('todolist/delete','Admin\TasksController@delete');
    Route::post('todolist/add_priority', 'Admin\TasksController@add_priority');
    Route::get('todolist/complete', 'Admin\TasksController@complete');
    Route::get('todolist/mytasks', 'Admin\TasksController@display_mytasks');
    Route::get('todolist/donemytasks', 'Admin\TasksController@display_done_mytasks');
    
    //Categoryのルーティング
    Route::get('categories/add','Admin\CategoriesController@add');
    Route::post('categories/create','Admin\CategoriesController@create');
    
    //Tagのルーティング
    Route::get('tags/add', 'Admin\TagsController@add');
    Route::post('tags/create', 'Admin\TagsController@create');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

