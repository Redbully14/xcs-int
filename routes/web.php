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
])->middleware('level:'.\Config::get('constants.access_level.member'));

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

Route::prefix('public')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: public
  | Category Name: PublicRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /public/roster
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster', [
    'as' => 'public.roster',
    'uses' => 'AntelopePublic@publicRoster_view'
  ]);

  /**
   * Webdomain: /public/roster/admins
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/admins', [
    'as' => 'public.roster.admins',
    'uses' => 'AntelopePublic@publicRoster_datatables_admins'
  ]);

  /**
   * Webdomain: /public/roster/seniorstaff
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/seniorstaff', [
    'as' => 'public.roster.seniorstaff',
    'uses' => 'AntelopePublic@publicRoster_datatables_seniorstaff'
  ]);

  /**
   * Webdomain: /public/roster/staff
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/staff', [
    'as' => 'public.roster.staff',
    'uses' => 'AntelopePublic@publicRoster_datatables_staff'
  ]);

  /**
   * Webdomain: /public/roster/staffintraining
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/staffintraining', [
    'as' => 'public.roster.staffintraining',
    'uses' => 'AntelopePublic@publicRoster_datatables_staffintraining'
  ]);

  /**
   * Webdomain: /public/roster/seniormember
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/seniormember', [
    'as' => 'public.roster.seniormember',
    'uses' => 'AntelopePublic@publicRoster_datatables_seniormember'
  ]);

  /**
   * Webdomain: /public/roster/member
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/member', [
    'as' => 'public.roster.member',
    'uses' => 'AntelopePublic@publicRoster_datatables_member'
  ]);

  /**
   * Webdomain: /public/roster/probationarymember
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/probationarymember', [
    'as' => 'public.roster.probationarymember',
    'uses' => 'AntelopePublic@publicRoster_datatables_probationarymember'
  ]);

  /**
   * Webdomain: /public/roster/reserve
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/reserve', [
    'as' => 'public.roster.reserve',
    'uses' => 'AntelopePublic@publicRoster_datatables_reserve'
  ]);

  /**
   * Webdomain: /public/roster/media
   *
   * @author Oliver G.
   * @package GET
   * @category PublicRoutes
   * @version 1.0.0
   */
  Route::get('roster/media', [
    'as' => 'public.roster.reserve',
    'uses' => 'AntelopePublic@publicRoster_datatables_media'
  ]);


  /*
  |--------------------------------------------------------------------------
  | x End PublicRoutes x
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

Route::prefix('investigative_search')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: investigative_search
  | Category Name: InvestigativeSearchRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /investigative_search/[KEY]
   *
   * @author Oliver G.
   * @package GET
   * @category InvestigativeSearchRoutes
   * @access Encrypted Route
   * @version 1.0.0
   */
  Route::get('/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET'), [
    'as' => 'investigative_search',
    'uses' => 'Antelope@investigativeSearch'
  ]);

  /**
   * Webdomain: /investigative_search/[KEY]/profile/{user}
   *
   * @author Oliver G.
   * @package GET
   * @category InvestigativeSearchRoutes
   * @access Encrypted Route
   * @version 1.0.0
   */
  Route::get('/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/{user}', [
    'as' => 'investigative_search.profile',
    'uses' => 'Antelope@investigativeSearch_search'
  ]);

  /**
   * Webdomain: /investigative_search/[KEY]/profile/activity/{user}
   *
   * @author Oliver G.
   * @package GET
   * @category InvestigativeSearchRoutes
   * @access Encrypted Route
   * @version 1.0.0
   */
  Route::get('/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/activity/{user}', [
    'as' => 'investigative_search.profile.activity',
    'uses' => 'AntelopeActivity@activityData'
  ]);

  /**
   * Webdomain: /investigative_search/[KEY]/profile/activity/get_data/{user}
   *
   * @author Oliver G.
   * @package POST
   * @category InvestigativeSearchRoutes
   * @access Encrypted Route
   * @version 1.0.0
   */
  Route::post('/'.env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET').'/profile/activity/get_data/{id}', [
    'as' => 'investigative_search.profile.activity.get_data',
    'uses' => 'AntelopeActivity@passActivityInstance'
  ]);

  /*
  |--------------------------------------------------------------------------
  | x End InvestigativeSearchRoutes x
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

    /**
     * Webdomain: /admin/getusername
     *
     * @author Oliver G.
     * @package GET
     * @category AdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::get('/getusername', [
      'as' => 'getusername',
      'uses' => 'BaseXCS@generateUsername'
    ]);

    /**
     * Webdomain: /admin/getpassworrd
     *
     * @author Oliver G.
     * @package GET
     * @category AdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::get('/getpassword', [
      'as' => 'getpassword',
      'uses' => 'BaseXCS@randomPassword'
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

    /**
     * Webdomain: /member_admin/clipboard
     *
     * @author Oliver G.
     * @package POST
     * @category MemberAdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/clipboard', [
      'as' => 'member_admin.clipboard',
      'uses' => 'Auth\NewMemberController@clipboard'
    ]);

    /**
     * Webdomain: /member_admin/delete/{id}
     *
     * @author Oliver G.
     * @package POST
     * @category MemberAdminRoutes
     * @access Admin
     * @version 1.0.0
     */
    Route::post('/delete/{id}', [
      'as' => 'member_admin.delete',
      'uses' => 'Auth\EditProfileController@softDelete'
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
     * Webdomain: /superadmin/icons2
     *
     * @author Oliver G.
     * @package GET
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::get('/icons2', [
      'as' => 'superadmin.icons2',
      'uses' => 'Antelope@superAdminIcons2'
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

    /**
     * Webdomain: /superadmin/notify
     *
     * @author Oliver G.
     * @package POST
     * @category SuperAdminRoutes
     * @access SuperAdmin
     * @version 1.0.0
     */
    Route::post('/notify', [
      'as' => 'superadmin.notify',
      'uses' => 'Antelope@superAdminNotify'
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

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category ActivityRoutes
   * @access SeniorStaff
   */
  Route::middleware('level:'.\Config::get('constants.access_level.seniorstaff'))->group(function () {

    /**
     * Webdomain: /activity/edit/{id}
     *
     * @author Oliver G.
     * @package POST
     * @category ActivityRoutes
     * @access SeniorStaff
     * @version 1.0.0
     */
    Route::post('/edit/{id}', [
      'as' => 'activity.edit',
      'uses' => 'AntelopeActivity@edit'
    ]);

    /**
     * Webdomain: /activity/delete/{id}
     *
     * @author Oliver G.
     * @package POST
     * @category ActivityRoutes
     * @access SeniorStaff
     * @version 1.0.0
     */
    Route::post('/delete/{id}', [
      'as' => 'activity.delete',
      'uses' => 'AntelopeActivity@softDelete'
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

Route::prefix('internal_roster')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: internal_roster
  | Category Name: InternalRosterRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Middleware check
   * All domains here require an access level to access
   *
   * @category InternalRosterRoutes
   * @access Senior Staff
   */
  Route::middleware('level:'.\Config::get('constants.access_level.seniorstaff'))->group(function () {

    /**
     * Webdomain: /internal_roster/
     *
     * @author Oliver G.
     * @package GET
     * @category InternalRosterRoutes
     * @access Senior Staff
     * @version 1.0.0
     */
    Route::get('/', [
      'as' => 'internal_roster',
      'uses' => 'Antelope@internalRoster_view'
    ]);

    /**
     * Webdomain: /internal_roster/edit/name/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category InternalRosterRoutes
     * @access Senior Staff
     * @version 1.0.0
     */
    Route::post('/edit/name/{user}', [
      'as' => 'internal_roster.edit.name',
      'uses' => 'Antelope@internalRoster_edit_name'
    ]);

    /**
     * Webdomain: /internal_roster/edit/websiteid/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category InternalRosterRoutes
     * @access Senior Staff
     * @version 1.0.0
     */
    Route::post('/edit/websiteid/{user}', [
      'as' => 'internal_roster.edit.websiteid',
      'uses' => 'Antelope@internalRoster_edit_websiteid'
    ]);

    /**
     * Webdomain: /internal_roster/edit/callsign/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category InternalRosterRoutes
     * @access Senior Staff
     * @version 1.0.0
     */
    Route::post('/edit/callsign/{user}', [
      'as' => 'internal_roster.edit.callsign',
      'uses' => 'Antelope@internalRoster_edit_callsign'
    ]);

    /**
     * Webdomain: /internal_roster/edit/rank/{user}
     *
     * @author Oliver G.
     * @package POST
     * @category InternalRosterRoutes
     * @access Senior Staff
     * @version 1.0.0
     */
    Route::post('/edit/rank/{user}', [
      'as' => 'internal_roster.edit.rank',
      'uses' => 'Antelope@internalRoster_edit_rank'
    ]);

  });

  /*
  |--------------------------------------------------------------------------
  | x End InternalRosterRoutes x
  |--------------------------------------------------------------------------
  */
});

Route::prefix('notifications')->group(function () {
  /*
  |--------------------------------------------------------------------------
  | Route Group: notifications
  | Category Name: NotificationRoutes
  |--------------------------------------------------------------------------
  |
  */

  /**
   * Webdomain: /notifications
   *
   * @author Oliver G.
   * @package GET
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::get('/', [
    'as' => 'notifications',
    'uses' => 'AntelopeNotifications@view'
  ]);

  /**
   * Webdomain: /notifications/clearall
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::post('/clearall', [
    'as' => 'notifications.clearall',
    'uses' => 'AntelopeNotifications@clearAllNotifications'
  ]);

  /**
   * Webdomain: /notifications/clearall_center
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::get('/clearall_center', [
    'as' => 'notifications.clearall_center',
    'uses' => 'AntelopeNotifications@clearAllNotificationsinCenter'
  ]);

  /**
   * Webdomain: /notifications/clear/{id}
   *
   * @author Oliver G.
   * @package POST
   * @category SettingsRoutes
   * @version 1.0.0
   */
  Route::get('/clear/{id}', [
    'as' => 'notifications.clear',
    'uses' => 'AntelopeNotifications@clearNotification'
  ]);

  /*
  |--------------------------------------------------------------------------
  | x End SettingsRoutes x
  |--------------------------------------------------------------------------
  */

});