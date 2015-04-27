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
Route::get('dashboard', 'HomeController@dashboard');
Route::get('/dashboard/deleteReview/{review_id}', 'HomeController@deleteReview');

Route::get('/dashboard/create-company', 'HomeController@createCompany');
Route::post('/dashboard/create-company', 'HomeController@postCreateCompany');
Route::get('/dashboard/edit-company/{company_id}', 'HomeController@editCompany');
Route::post('/dashboard/edit-company/{company_id}', 'HomeController@postEditCompany');
Route::get('/dashboard/delete-company/{company_id}', 'HomeController@deleteCompany');

Route::post('/dashboard/approve-review/{review_id}', 'HomeController@approveReview');
Route::post('/dashboard/disapprove-review/{review_id}', 'HomeController@disapproveReview');


Route::get('/company/{company_name}', 'HomeController@companyInfo');
Route::get('/companies', 'HomeController@companies');

Route::post('review', 'HomeController@postReview');
Route::get('review', 'HomeController@review');

Route::get('signup', 'LoginController@signup');
Route::post('signup', 'LoginController@postSignup');
Route::get('login', 'LoginController@login');
Route::post('login', 'LoginController@postLogin');
Route::get('logout', 'LoginController@logout');


Route::get('/', 'WelcomeController@index');
/*
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
