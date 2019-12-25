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
	'uses' => 'Auth\InactiveController@inactive'
]);
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
Route::get('/dashboard', 'Antelope@dashboard');
Route::get('/xcsinfo', 'BaseXCS@xcsInfo');
Route::get('/member_admin', 'Antelope@memberAdmin')->middleware('level:'.\Config::get('constants.access_level.admin'));
Route::get('/member_admin/get_users', 'Antelope@passUserData')->middleware('level:'.\Config::get('constants.access_level.admin'));
Route::get('/superadmin/help', function () {
    return view('stackpath.superadmin_help');
})->middleware('level:'.\Config::get('constants.access_level.superadmin'));

// Activty GET Routes
Route::get('/activity', 'AntelopeActivity@constructPage')->middleware('level:'.\Config::get('constants.access_level.staff'));
Route::get('/activity/collection', 'AntelopeActivity@passActivityData')->middleware('level:'.\Config::get('constants.access_level.staff'));
Route::get('/activity/get_profile_logs/{user}', 'AntelopeActivity@activityData')->middleware('level:'.\Config::get('constants.access_level.sit'));

// POST routes
Route::post('/member_admin/new', 'Auth\NewMemberController@register')->middleware('level:'.\Config::get('constants.access_level.admin'));
Route::post('/member/edit/get_data/{user}', 'Auth\EditProfileController@userdata')->middleware('level:'.\Config::get('constants.access_level.sit'));
Route::post('/member/edit/edit_user/{user}', 'Auth\EditProfileController@edit')->middleware('level:'.\Config::get('constants.access_level.sit'));
Route::post('/activity/get_data/{user}', 'AntelopeActivity@passActivityInstance')->middleware('level:'.\Config::get('constants.access_level.staff'));
Route::post('/activity/submit', 'AntelopeActivity@submit')->middleware('level:'.\Config::get('constants.access_level.member'));