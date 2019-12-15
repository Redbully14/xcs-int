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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

// IMPORTANT IMPORTANT IMPORTANT: Fucking delete this once Antelope goes live otherwise there will be 5000 olivers in the database
Route::get('/oliver', 'Auth\MakeMyAccountController@makeOliver');

// Authentication Routes
Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/inactive', [
	'as' => 'inactive',
	'uses' => 'Auth\InactiveController@inactive']);
Route::get('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);

// Main GET Routes
Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/dashboard', 'AntelopeController@dashboard');
Route::get('/xcsinfo', 'BaseXCS@xcsInfo');
Route::get('/member_admin', 'AntelopeController@memberAdmin');

// POST routes
Route::post('/member_admin/new', 'Auth\NewMemberController@register');