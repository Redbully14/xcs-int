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
    {;
        return User::find($user);
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
            'name' => ['required', 'string', 'max:255'],
            'website_id' => ['required', 'integer'],
            'department_id' => ['string', 'max:10'],
            'rank' => ['required', 'string', 'max:30'],
            'antelope_status' => ['required'],
        ]);
    }

    public function edit(User $user)
    {
        $this->validator(request()->all())->validate();


        $user->name = request('name');
        $user->website_id = request('website_id');
        $user->rank = request('rank');
        $user->department_id = request('department_id');
        $user->antelope_status = request('antelope_status') ? 1 : 0;
        $user->save();

        return;
    }
}