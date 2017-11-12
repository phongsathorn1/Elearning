<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::resource('classroom', 'ClassroomController');
    Route::resource('post', 'PostController');
    Route::resource('classroom/{classroom_id}/assignment', 'AssignmentController');
    Route::post('classroom/{classroom_id}/assignment/{id}/upload', 'AssignmentController@upload');
    Route::post('classroom/{classroom_id}/assignment/{id}/remove', 'AssignmentController@removeFile');
    Route::get('classroom/{classroom_id}/assignment/{id}/confirm', 'AssignmentController@confirm');
    Route::get('classroom/{classroom_id}/assignment/{id}/done', 'AssignmentController@alldone');
    // Route::get('classroom/{classroom_id}/assignment/{id}')
    Route::resource('comments', 'CommentController');
    Route::resource('members', 'MemberController')->middleware('role:is_teacher');
    Route::post('members/add', 'MemberController@add')->middleware('role:is_teacher');
    Route::post('members/remove', 'MemberController@remove')->middleware('role:is_teacher');
    Route::get('me', 'UserController@index');
});
