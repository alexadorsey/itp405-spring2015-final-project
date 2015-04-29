<?php


Route::get('home', 'HomeController@home');
Route::post('search', 'HomeController@search');

/* Admin Page */
Route::get('dashboard', 'DashboardController@dashboard');
Route::get('/dashboard/deleteReview/{review_id}', 'DashboardController@deleteReview');

Route::get('/dashboard/create-company', 'DashboardController@createCompany');
Route::post('/dashboard/create-company', 'DashboardController@postCreateCompany');
Route::get('/dashboard/edit-company/{company_id}', 'DashboardController@editCompany');
Route::post('/dashboard/edit-company/{company_id}', 'DashboardController@postEditCompany');
Route::get('/dashboard/delete-company/{company_id}', 'DashboardController@deleteCompany');

Route::get('/dashboard/create-position', 'DashboardController@createPosition');
Route::post('/dashboard/create-position', 'DashboardController@postCreatePosition');
Route::get('/dashboard/edit-position/{position_id}', 'DashboardController@editPosition');
Route::post('/dashboard/edit-position/{position_id}', 'DashboardController@postEditPosition');
Route::get('/dashboard/delete-position/{position_id}', 'DashboardController@deletePosition');

Route::get('/dashboard/create-city', 'DashboardController@createCity');
Route::post('/dashboard/create-city', 'DashboardController@postCreateCity');
Route::get('/dashboard/edit-city/{city_id}', 'DashboardController@editCity');
Route::post('/dashboard/edit-city/{city_id}', 'DashboardController@postEditCity');
Route::get('/dashboard/delete-city/{city_id}', 'DashboardController@deleteCity');

Route::post('/dashboard/approve-review/{review_id}', 'DashboardController@approveReview');
Route::post('/dashboard/disapprove-review/{review_id}', 'DashboardController@disapproveReview');


/* Company Profile Page */
Route::get('/company/{company_name}', 'HomeController@companyInfo');
Route::get('/companies', 'HomeController@companies');


/* Review Page */
Route::post('review', 'ReviewController@postReview');
Route::get('review', 'ReviewController@review');


/* Login Page */
Route::get('signup', 'LoginController@signup');
Route::post('signup', 'LoginController@postSignup');
Route::get('login', 'LoginController@login');
Route::post('login', 'LoginController@postLogin');
Route::get('logout', 'LoginController@logout');


Route::get('/', 'WelcomeController@index');
