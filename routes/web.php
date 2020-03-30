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
    return view('welcome');
});

Route::get('/', 'PageController@registration')->name('registration');
Route::post('/', 'PageController@savePlayers')->name('savePlayers');
Route::get('/pingpong', 'PageController@pingpong')->name('pingpong');
Route::post('/pingpong', 'PageController@setPoint')->name('setPoint');
Route::post('/end', 'PageController@end')->name('end');
