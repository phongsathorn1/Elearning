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
    Route::post('classroom/join', 'ClassroomController@join');
    Route::resource('post', 'PostController');
    Route::get('classroom/{classroom_id}/get', 'ClassroomController@getClassroom');
    Route::resource('classroom/{classroom_id}/assignment', 'AssignmentController');
    Route::post('classroom/{classroom_id}/assignment/{id}/upload', 'AssignmentController@upload');
    Route::post('classroom/{classroom_id}/assignment/{id}/remove', 'AssignmentController@removeFile');
    Route::get('classroom/{classroom_id}/assignment/{id}/confirm', 'AssignmentController@confirm');
    Route::get('classroom/{classroom_id}/assignment/{id}/done', 'AssignmentController@alldone');
    Route::get('classroom/{classroom_id}/assignment/{id}/post', 'AssignmentController@getPost');
    Route::patch('classroom/{classroom_id}/assignment/{id}/post', 'AssignmentController@editPost');
    Route::resource('comments', 'CommentController');
    Route::get('members/{classroom_id}', 'MemberController@show');
    Route::resource('members', 'MemberController', ['except' => ['show']])->middleware('role:is_teacher');
    Route::post('members/add', 'MemberController@add')->middleware('role:is_teacher');
    Route::post('members/remove', 'MemberController@remove')->middleware('role:is_teacher');
    Route::get('me', 'UserController@index');
    Route::get('assignment/download/{file_id}', 'FileController@assignment');
    Route::get('attachment/download/{file_id}', 'FileController@attachment');
    Route::post('attachment/upload', 'FilesAttachmentController@upload');
});
