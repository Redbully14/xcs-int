<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Http\Controllers\BaseXCS;
use App\Notifications\Welcome;

class NewMemberController extends Controller
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->constants = \Config::get('constants');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:30'],
            'rank' => ['required', 'string', 'max:30'],
            'website_id' => ['required', 'integer'],
            'department_id' => ['string', 'max:30', 'nullable'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'rank' => $data['rank'],
            'website_id' => $data['website_id'],
            'department_id' => $data['department_id'],
        ]);

        $role = Role::where('slug', '=', $data['role'])->first();
        $user->attachRole($role);

        $user->notify(new Welcome());

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $data = $request->all();
        $processed_data = [
            'username' => $user->username,
            'password' => $data['password'],
        ];

        return $processed_data;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

    /**
     * Handles a clipboard new member request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clipboard(Request $request)
    {
        $data = $request->all();
        $data['username'] = (string) BaseXCS::generateUsername();
        $data['password'] = BaseXCS::randomPassword();
        $data['role'] = 'member';
        $data['rank'] = array_search($data['rank'], $this->constants['rank'], true);

        $request['password'] = $data['password'];

        $this->validator($data)->validate();

        event(new Registered($user = $this->create($data)));

        return $this->registered($request, $user);
    }
}