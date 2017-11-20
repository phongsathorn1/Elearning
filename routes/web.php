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

// Route::get('/', function () {
//     return view('app');
// });

// Route::get('/login', function() {
//     return redirect()->home();
// })->name('login');

Route::get('download/file/{filepath}/', 'FileController@download');
Route::get('download/assignment/{assignment_id}/{filepath}/', 'FileController@downloadAssignment');
Route::get('thumbnail/file/{filepath}', 'FileController@downloadImage');
Route::get('beta/login/', function(){
    return view('login');
});

Route::any('{all}', function () {
    return view('app');
})->where(['all' => '.*']);