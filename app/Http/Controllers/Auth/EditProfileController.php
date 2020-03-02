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
use Symfony\Component\HttpFoundation\JsonResponse;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Http\Controllers\BaseXCS;
use App\Notifications\Promotion;
use App\Notifications\AccessChanged;
use App\Notifications\NewUnitNumber;

class EditProfileController extends Controller
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
    }

    /**
     * Compile Edit Modal
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function userdata($user)
    {
        $user = User::find($user);

        $user = $user->load('roles');

        return $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($username, array $data)
    {
        $username = $username->username;
        $data['antelope_status'] = $data['antelope_status'] ? true : false;
        $data['requirements_exempt'] = $data['requirements_exempt'] ? true : false;
        $data['advanced_training'] = $data['advanced_training'] ? true : false;

        if($username == $data['username']) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:30'],
                'rank' => ['required', 'string', 'max:30'],
                'website_id' => ['required', 'integer'],
                'department_id' => ['string', 'max:30', 'nullable'],
                'antelope_status' => ['required', 'boolean'],
                'requirements_exempt' => ['required', 'boolean'],
                'advanced_training' => ['required', 'boolean'],
            ]);
        }
        else {
            return Validator::make($data, [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:30'],
                'rank' => ['required', 'string', 'max:30'],
                'website_id' => ['required', 'integer'],
                'department_id' => ['string', 'max:30', 'nullable'],
                'antelope_status' => ['required', 'boolean'],
                'requirements_exempt' => ['required', 'boolean'],
                'advanced_training' => ['required', 'boolean'],
            ]);
        }
    }

    public function edit(Request $request)
    {
        $user = User::find($request->route('user'));
        $this->validator($user, $request->all())->validate();


        $user->name = $request['name'];
        $user->website_id = $request['website_id'];
        if(\Config::get('constants')['rank_level'][$user->rank] < \Config::get('constants')['rank_level'][$request['rank']]) {
            $user->notify(new Promotion($request['rank']));
        }
        $user->rank = $request['rank'];
        
        if($user->department_id != $request['department_id']) {
            $user->notify(new NewUnitNumber($user->department_id, $request['department_id']));
        }
        $user->department_id = $request['department_id'];

        $user->antelope_status = $request['antelope_status'];
        if($user->roles()->first()->slug != $request['role']) {
            $user->notify(new AccessChanged($user->roles()->first()->level, $request['role']));
        }

        $role = Role::where('slug', '=', $request['role'])->first();
        $user->username = $request['username'];
        $user->requirements_exempt = $request['requirements_exempt'];
        $user->advanced_training = $request['advanced_training'];
        $user->save();
        $user->roles()->sync($role);

        return;
    }

    public function editpassword(Request $request)
    {
        $user = User::find($request->route('user'));

        $request->validate([
            'new_password' => ['required', 'string', 'min:8']
        ]);

        $user->password = Hash::make($request->new_password);
        $user->temp_password = 1;
        $user->save();

        return;
    }

    public function softDelete($id)
    {
        User::destroy($id);

        return;
    }

}
