<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Http\Controllers\BaseXCS;

class MakeMyAccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function makeOliver()
    {
        $this->makeTester();

        $user = User::create([
            'username' => 'redbully14',
            'password' => Hash::make('password'),
            'name' => 'Oliver G.',
            'rank' => 'manager',
            'website_id' => 519,
            'department_id' => 'Civ-9',
            'temp_password' => 0,
        ]);

        $role = Role::where('slug', '=', 'superadmin')->first();
        $user->attachRole($role);

        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function makeTester()
    {
        $user = User::create([
            'username' => 'antelope',
            'password' => Hash::make('password'),
            'name' => 'AntelopePHP',
            'rank' => 'director',
            'website_id' => 1,
            'department_id' => null,
            'temp_password' => 0,
        ]);

        $role = Role::where('slug', '=', 'superadmin')->first();
        $user->attachRole($role);

        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function makeSuperAdmin()
    {
        $username = BaseXCS::generateUsername();
        $password = BaseXCS::randomPassword();

        $user = User::create([
            'username' => $username,
            'password' => Hash::make($password),
            'name' => 'DOJ Beta Tester',
            'rank' => 'other_guest',
            'website_id' => mt_rand(1, 999999),
            'department_id' => null,
            'temp_password' => 1,
        ]);

        $role = Role::where('slug', '=', 'superadmin')->first();
        $user->attachRole($role);

        $user_data = [
            'username' => $username,
            'password' => $password,
        ];

        return view('make_my_superadmin')->with('user_data', $user_data);
    }
}