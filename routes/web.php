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

Route::get('/getListPeople', 'peopleController@index');
Route::get('/getListReward', 'rewardController@index');

Route::get('/chkDB', function () {
    // Test database connection
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

Route::get('/random', function () {
    return view('random');
});

Route::get('/reward', function () {
    return view('reward');
});
