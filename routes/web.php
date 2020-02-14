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

/*
|--------------------------------------------------------------------------
| REMOVE THESE FOLLOWING ROUTES BEFORE THE APPLICATION GOES INTO PRODUCTION
|--------------------------------------------------------------------------
|
*/
Route::get('/oliver', 'Auth\MakeMyAccountController@makeOliver');
Route::get('/api/gimme', 'Api\ApiTokenController@gimme');

/*
|--------------------------------------------------------------------------
| Main Website Routes
|--------------------------------------------------------------------------
|
*/

/**
 * Webdomain: /dashboard
 *
 * @author Oliver G.
 * @package GET
 * @category BaseRoutes
 * @version 1.0.0
 */
Route::get('/dashboard', [
  'as' => 'dashboard',
  'uses' => 'Antelope@dashboard'
]);

Route::get('/', function () {
    return redirect('/dashboard');
});

/**
 * Webdomain: /profile/{user}
 *
 * @author Oliver G.
 * @package GET
 * @category BaseRoutes
 * @access SIT
 * @version 1.0.0
 */
Route::get('/profile/{user}', [
  'as' => 'profile',
  'uses' => 'Antelope@getProfile'
])->middleware('level:'.\Config::get('constants.access_level.sit'));

/**
 * Webdomain: /myprofile
 *
 * @author Oliver G.
 * @package GET
 * @category BaseRoutes
 * @version 1.0.0
 */
Route::get('/myprofile', [
  'as' => 'myprofile',
  'uses' => 'Antelope@myProfile'
]);

/**
 * Webdomain: /myprofile
 *
 * @author Oliver G.
 * @package POST
 * @category BaseRoutes
 * @version 1.0.0
 */
Route::post('/feedback/', [
  'as' => 'feedback',
  'uses' => 'Antelope@feedbackSubmit'
]);

/*
|--------------------------------------------------------------------------
| Route Groups
|--------------------------------------------------------------------------
|
*/

Route::prefix('settings')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: settings
  | Category Name: SettingsRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /settings
   *
   * @author Oliver G.
   * @package GET
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::get('/', [
    'as' => 'settings',
    'uses' => 'Antelope@accountSettings'
  ]);

  /**
   * Webdomain: /settings/change_password
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::post('/change_password', [
    'as' => 'settings.change_password',
    'uses' => 'Auth\ChangePasswordController@store'
  ]);

  /**
   * Webdomain: /settings/change_avatar
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::post('/change_avatar', [
    'as' => 'settings.change_avatar',
    'uses' => 'Antelope@setAvatar'
  ]);

  /**
   * Webdomain: /settings/change_timezone
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::post('/change_timezone', [
    'as' => 'settings.change_timezone',
    'uses' => 'Antelope@setTimezone'
  ]);

  /*
  |--------------------------------------------------------------------------
  | x End SettingsRoutes x
  |--------------------------------------------------------------------------
  */

});

Route::namespace('Auth')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Authentication Routes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /logout
   *
   * @author Oliver G.
   * @package GET
   * @category AuthenticationRoutes
   * @version 1.0.0
   */
  Route::get('logout', 'LoginController@logout', function () {
      return abort(404);
  });

  /**
   * Webdomain: /register
   *
   * @author Oliver G.
   * @package GET
   * @category AuthenticationRoutes
   * @version 1.0.0
   */
  Route::get('/register', [
    'as' => 'register',
    'uses' => 'RegistrationController@view'
  ]);

  Route::post('/register/submit', [
    'uses' => 'RegistrationController@submit'
  ]);

  /**
   * Webdomain: /inactive
   *
   * @author Oliver G.
   * @package GET
   * @category AuthenticationRoutes
   * @version 1.0.0
   */
  Route::get('/inactive', [
    'as' => 'inactive',
    'uses' => 'InactiveController@inactive'
  ]);

  /**
   * Webdomain: /login
   *
   * @author Oliver G.
   * @package GET/POST
   * @category AuthenticationRoutes
   * @version 1.0.0
   */
  Route::get('login', [
    'as' => 'login',
    'uses' => 'LoginController@showLoginForm'
  ]);

  Route::post('login', [
    'uses' => 'LoginController@login'
  ]);

  /**
   * Webdomain: /logout
   *
   * @author Oliver G.
   * @package POST
   * @category AuthenticationRoutes
   * @version 1.0.0
   */
  Route::post('logout', [
    'as' => 'logout',
    'uses' => 'LoginController@logout'
  ]);

  /*
  |--------------------------------------------------------------------------
  | x End AuthenticationRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('member')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: member
  | Category Name: MemberRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category MemberRoutes
   * @access SIT
   */
  Route::middleware('level:'.\Config::get('constants.access_level.sit'))->group(function () {

    /**
     * Webdomain: /member/edit/get_data/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category MemberRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::post('/edit/get_data/{user}', [
      'as' => 'member.edit.get_data',
      'uses' => 'Auth\EditProfileController@userdata'
    ]);

    /**
     * Webdomain: /member/edit/edit_user/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category MemberRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::post('/edit/edit_user/{user}', [
      'as' => 'member.edit.edit_user',
      'uses' => 'Auth\EditProfileController@edit'
    ]);

  });

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category MemberRoutes
   * @access Admin
   */
  Route::middleware('level:'.\Config::get('constants.access_level.admin'))->group(function () {

    /**
     * Webdomain: /member/edit/edit_user_password/{user}
     *
     * @author Christopher M.
     * @package POST
     * @category MemberRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/edit/edit_user_password/{user}', [
      'as' => 'member.edit.edit_user_password',
      'uses' => 'Auth\EditProfileController@editpassword'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End MemberRoutes x
  |--------------------------------------------------------------------------
  */

});

Route::prefix('admin')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: admin
  | Category Name: AdminRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category AdminRoutes
   * @access Admin
   */
  Route::middleware('level:'.\Config::get('constants.access_level.admin'))->group(function () {

    /**
     * Webdomain: /admin/settings
     *
     * @author Oliver G.
     * @package GET
     * @category AdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::get('/settings', [
      'as' => 'admin.settings',
      'uses' => 'Antelope@adminSettings_view'
    ]);

    /**
     * Webdomain: /admin/quicklink/add
     *
     * @author Oliver G.
     * @package POST
     * @category AdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/quicklink/add', [
      'as' => 'admin.quicklink.add',
      'uses' => 'Antelope@adminSettings_addQuickLink'
    ]);

    /**
     * Webdomain: /admin/quicklink/manage
     *
     * @author Oliver G.
     * @package POST
     * @category AdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/quicklink/manage', [
      'as' => 'admin.quicklink.manage',
      'uses' => 'Antelope@adminSettings_manageQuickLink'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End AdminRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('member_admin')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: member_admin
  | Category Name: MemberAdminRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category MemberAdminRoutes
   * @access Admin
   */
  Route::middleware('level:'.\Config::get('constants.access_level.admin'))->group(function () {

    /**
     * Webdomain: /member_admin
     *
     * @author Oliver G.
     * @package GET
     * @category MemberAdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'member_admin',
      'uses' => 'Antelope@memberAdmin'
    ]);

    /**
     * Webdomain: /member_admin/get_users
     *
     * @author Oliver G.
     * @package GET
     * @category MemberAdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::get('/get_users', [
      'as' => 'member_admin.get_users',
      'uses' => 'Antelope@passUserData'
    ]);

    /**
     * Webdomain: /member_admin/new
     *
     * @author Oliver G.
     * @package POST
     * @category MemberAdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/new', [
      'as' => 'member_admin.new',
      'uses' => 'Auth\NewMemberController@register'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End MemberAdminRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('superadmin')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: superadmin
  | Category Name: SuperAdminRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /superadmin/normalmode
   *
   * @author Oliver G.
   * @package GET
   * @category SuperAdminRoutes
   * @version 1.0.0
   * @access Public
   */
  Route::get('/normalmode', [
    'as' => 'superadmin.normalmode',
    'uses' => 'Antelope@superStopGodmode'
  ]);

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category SuperAdminRoutes
   * @access SuperAdmin
   */
  Route::middleware('level:'.\Config::get('constants.access_level.superadmin'))->group(function () {

    /**
     * Webdomain: /superadmin
     *
     * @author Oliver G.
     * @package GET
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'superadmin',
      'uses' => 'Antelope@superAdmin'
    ]);

    /**
     * Webdomain: /superadmin/help
     *
     * @author Oliver G.
     * @package GET
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::get('/help', function () {
      return view('stackpath.superadmin_help');
    });

    /**
     * Webdomain: /superadmin/icons
     *
     * @author Oliver G.
     * @package GET
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::get('/icons', [
      'as' => 'superadmin.icons',
      'uses' => 'Antelope@superAdminIcons'
    ]);

    /**
     * Webdomain: /superadmin/icons
     *
     * @author Oliver G.
     * @package POST
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::post('/godmode', [
      'as' => 'superadmin.godmode',
      'uses' => 'Antelope@superAdminGodmode'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End SuperAdminRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('activity')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: activity
  | Category Name: ActivityRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /activity/get_profile_logs/{user}
   *
   * @author Oliver G.
   * @package GET
   * @category ActivityRoutes
   * @access Public
   * @version 1.0.0
   */
  Route::get('/get_profile_logs/{user}', [
    'as' => 'activity.get_profile_logs',
    'uses' => 'AntelopeActivity@activityData'
  ]);

  /**
   * Webdomain: /activity/get_data/{user}
   *
   * @author Oliver G.
   * @package POST
   * @category ActivityRoutes
   * @access Public
   * @version 1.0.0
   */
  Route::post('/get_data/{user}', [
    'as' => 'activity.get_data',
    'uses' => 'AntelopeActivity@passActivityInstance'
  ]);

  /**
   * Webdomain: /activity/get_flag_data/{user}
   *
   * @author Christopher M.
   * @package POST
   * @category ActivityRoutes
   * @access Public
   * @version 1.0.0
   */
  Route::post('/get_flag_data/{user}', [
    'as' => 'activity.get_flag_data',
    'uses' => 'AntelopeActivity@passActivityFlagInstance'
  ]);

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category ActivityRoutes
   * @access Member
   */
  Route::middleware('level:'.\Config::get('constants.access_level.member'))->group(function () {

    /**
     * Webdomain: /activity/submit
     *
     * @author Oliver G.
     * @package POST
     * @category ActivityRoutes
     * @access Member
     * @version 1.0.0
     */
    Route::post('/submit', [
      'as' => 'activity.submit',
      'uses' => 'AntelopeActivity@submit'
    ]);

  });

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category ActivityRoutes
   * @access Staff
   */
  Route::middleware('level:'.\Config::get('constants.access_level.staff'))->group(function () {

    /**
     * Webdomain: /activity
     *
     * @author Oliver G.
     * @package GET
     * @category ActivityRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'activity',
      'uses' => 'AntelopeActivity@constructPage'
    ]);

    /**
     * Webdomain: /activity/collection
     *
     * @author Oliver G.
     * @package GET
     * @category ActivityRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::get('/collection', [
      'as' => 'activity.collection',
      'uses' => 'AntelopeActivity@passActivityData'
    ]);

    /**
     * Webdomain: /activity/edit_flag_data/{id}
     *
     * @author Christopher M.
     * @package POST
     * @category ActivityRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::post('/edit_flag_data/{id}', [
      'as' => 'activity.edit_flag_data',
      'uses' => 'AntelopeActivity@editActivityFlagInstance'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End ActivityRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('discipline')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: discipline
  | Category Name: DisciplineRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category DisciplineRoutes
   * @access SIT
   */
  Route::middleware('level:'.\Config::get('constants.access_level.sit'))->group(function () {

    /**
     * Webdomain: /discipline
     *
     * @author Oliver G.
     * @package GET
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'discipline',
      'uses' => 'AntelopeDiscipline@constructPage'
    ]);

    /**
     * Webdomain: /discipline/collection
     *
     * @author Oliver G.
     * @package GET
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::get('/collection', [
      'as' => 'discipline.collection',
      'uses' => 'AntelopeDiscipline@constructDisciplineTable'
    ]);

    /**
     * Webdomain: /discipline/get_profile_discipline/{user}
     *
     * @author Oliver G.
     * @package GET
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::get('/get_profile_discipline/{user}', [
      'as' => 'discipline.get_profile_discipline',
      'uses' => 'AntelopeDiscipline@constructDisciplineTable'
    ]);

    /**
     * Webdomain: /discipline/submit
     *
     * @author Oliver G.
     * @package POST
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::post('/submit', [
      'as' => 'discipline.submit',
      'uses' => 'AntelopeDiscipline@submit'
    ]);

    /**
     * Webdomain: /discipline/get_data/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::post('/get_data/{user}', [
      'as' => 'discipline.get_data',
      'uses' => 'AntelopeDiscipline@getDiscipline'
    ]);

    /**
     * Webdomain: /discipline/edit/{id}
     *
     * @author Oliver G.
     * @package POST
     * @category DisciplineRoutes
     * @access SIT
     * @version 1.0.0
     */
    Route::post('/edit/{id}', [
      'as' => 'discipline.edit',
      'uses' => 'AntelopeDiscipline@edit'
    ]);


  });

  /*
  |--------------------------------------------------------------------------
  | x End DisciplineRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('absence')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: absence
  | Category Name: AbsenceRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category AbsenceRoutes
   * @access Staff
   */
  Route::middleware('level:'.\Config::get('constants.access_level.sit'))->group(function () {

    /**
     * Webdomain: /absence
     *
     * @author Oliver G.
     * @package GET
     * @category AbsenceRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'absence',
      'uses' => 'AntelopeAbsence@view'
    ]);

    /**
     * Webdomain: /absence/datatable/{status}
     *
     * @author Oliver G.
     * @package GET
     * @category AbsenceRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::get('/datatable/{status}', [
      'as' => 'absence.datatable',
      'uses' => 'AntelopeAbsence@passAbsenceDataTable'
    ]);

    /**
     * Webdomain: /absence/approve/{id}
     *
     * @author Oliver G.
     * @package GET
     * @category AbsenceRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::post('/approve/{id}', [
      'as' => 'absence.approve',
      'uses' => 'AntelopeAbsence@approveAbsence'
    ]);

    /**
     * Webdomain: /absence/archive/{id}
     *
     * @author Oliver G.
     * @package GET
     * @category AbsenceRoutes
     * @access Staff
     * @version 1.0.0
     */
    Route::post('/archive/{id}', [
      'as' => 'absence.archive',
      'uses' => 'AntelopeAbsence@archiveAbsence'
    ]);

    /**
     * Webdomain: /absence/queue/{id}
     *
     * @author Oliver G.
     * @package GET
     * @category QueueAbsence
     * @access Staff
     * @version 1.0.0
     */
    Route::post('/queue/{id}', [
      'as' => 'absence.queue',
      'uses' => 'AntelopeAbsence@queueAbsence'
    ]);

  });

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category AbsenceRoutes
   * @access SeniorStaff
   */
  Route::middleware('level:'.\Config::get('constants.access_level.sit'))->group(function () {

    /**
     * Webdomain: /absence/archive
     *
     * @author Oliver G.
     * @package GET
     * @category BaseRoutes
     * @access SeniorStaff
     * @version 1.0.0
     */
    Route::get('/archive', [
      'as' => 'absence.archive',
      'uses' => 'AntelopeAbsence@archive'
    ]);

  });

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category AbsenceRoutes
   * @access Member
   */
  Route::middleware('level:'.\Config::get('constants.access_level.member'))->group(function () {

    /**
     * Webdomain: /absence/submit
     *
     * @author Oliver G.
     * @package POST
     * @category BaseRoutes
     * @access Member
     * @version 1.0.0
     */
    Route::post('/submit', [
      'as' => 'absence.submit',
      'uses' => 'AntelopeAbsence@submit'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End AbsenceRoutes x
  |--------------------------------------------------------------------------
  */
});