<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/home', 'HomeController@index');
Route::get('/home', ['middleware' => 'auth', function() {
    return view('home');
}]);

//===User Login/Logout/Register===
//Route::auth();
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');
Route::get('register', 'Auth\AuthController@showRegistrationForm');
Route::post('register', 'Auth\AuthController@register');

//===Company===
/*Route::get('chooseCo',  ['middleware' => 'auth', function() {
    return view('selectCompany');
}]);*/
Route::get('registerCo', 'CompanyController@index');
Route::post('registerCo', 'CompanyController@store');



Route::get('chooseCo', 'COAController@index');
Route::get('chooseCo2', 'COAController@index2');
//Route::get('/test', 'COAController@testIndex');
//Route::get('/m', 'COAController@testMagic');
Route::get('/m2', 'COAController@testMagic2');
//Route::get('/t', 'COAController@testTable');
Route::get('/t2', 'COAController@testTable2');


//Route::resource('abc', 'COAController');
Route::get('/testTData', 'COAController@testTableT');
Route::post('/testTData', 'COAController@testTableTPost');
Route::put('/testTData', 'COAController@testTableTPut');
Route::delete('/testTData', 'COAController@testTableTDel');



