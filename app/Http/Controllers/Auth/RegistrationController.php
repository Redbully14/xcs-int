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

class RegistrationController extends Controller
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
     * Return the view for the page
     *
     * @return void
     */
    public function view()
    {
        if(auth()->user()->temp_password) {
            $constants = \Config::get('constants');
            return view('auth.register')->with('constants', $constants);
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Change the user's password and timezone
     *
     * @return void
     */
    public function submit(Request $request)
    {
        if(auth()->user()->username == $request->username) {
            $request->validate([
                'new_password' => ['required', 'string', 'min:8'],
                'new_confirm_password' => ['same:new_password'],
                'timezone' => ['required', 'string'] // todo: make a rule that will check if it's in constants.
            ]);
        } else {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'new_password' => ['required', 'string', 'min:8'],
                'new_confirm_password' => ['same:new_password'],
                'timezone' => ['required', 'string'] // todo: make a rule that will check if it's in constants.
            ]);
        }
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        User::find(auth()->user()->id)->update(['username'=> $request->username]);
        if(User::find(auth()->user()->id)->get('temp_password')) {
            User::find(auth()->user()->id)->update(['temp_password' => 0]);
        }

        User::find(auth()->user()->id)->update(['timezone' => $request->timezone]);

        return response()->json([
          'redirect_to' => route('dashboard')
        ]); 
    }
}