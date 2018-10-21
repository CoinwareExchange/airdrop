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

Route::get('/', 'AirdropController@index');

Route::post('/registerAir', 'AirdropController@registerAir');

Route::get('/dashboard', function(){
	return view('airdrop.dashboard');
})->middleware('auth');

Route::post('/telegramusers', 'AirdropController@telegramUsers');

Route::post('/verifyTelegramUser', 'AirdropController@verifyTelegram');

Route::post('/verifyTwitterUser', 'AirdropController@verifyTwitter');

Route::get('/logout','Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
