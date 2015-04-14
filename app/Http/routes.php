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

Route::get('home', 'HomeController@home');
Route::get('search', 'HomeController@search');
Route::post('search/sort', 'HomeController@searchSortBy');
Route::get('dashboard', 'HomeController@dashboard');
Route::get('/company/{company_name}', 'HomeController@companyInfo');

Route::post('review', 'HomeController@postReview');
Route::get('review', 'HomeController@review');

Route::get('signup', 'LoginController@signup');
Route::post('signup', 'LoginController@postSignup');
Route::get('login', 'LoginController@login');
Route::post('login', 'LoginController@postLogin');
Route::get('logout', 'LoginController@logout');

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
