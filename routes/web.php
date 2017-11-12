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
    return view('app');
});

Route::group(['prefix' => 'api/'], function(){
    Route::group(['middleware' => 'auth:api'], function(){
        Route::resource('classroom', 'ClassroomController');
        Route::resource('post', 'PostController');
        Route::resource('classroom/{classroom_id}/assignment', 'AssignmentController');
        Route::resource('comments', 'CommentController');
        Route::resource('members', 'MemberController')->middleware('role:is_teacher');
        Route::post('members/add', 'MemberController@add')->middleware('role:is_teacher');
        Route::post('members/remove', 'MemberController@remove')->middleware('role:is_teacher');
        Route::get('me', 'UserController@index');
    });
});