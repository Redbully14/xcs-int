<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class Antelope extends Controller
{
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
     * Connects a person to the main dashboard
     *
     * @return View
     */
    public function dashboard()
    {
    	$constants = \Config::get('constants');

    	return view('dashboard')->with('constants', $constants);
    }

    /**
     * Gives a person access to the member administration
     *
     * @return View
     */
    public function memberAdmin()
    {
        $constants = \Config::get('constants');

        // remove the ability to add superadmins
        array_shift($constants['role']);

        return view('member_admin')->with('constants', $constants);
    }

    /**
     * Gets all users in database
     *
     * @return View
     */
    public function passUserData()
    {
        return Datatables::of(User::query()->with('roles'))->make(true);
    }

    /**
     * Returns and generates the account settings view.
     *
     * @return View
     */
    public function accountSettings()
    {
        $constants = \Config::get('constants');

        return view('account_settings')->with('constants', $constants);
    }

    /**
     * Change user avatar.
     *
     * @return View
     */
    public function setAvatar(Request $request)
    {
        $constants = \Config::get('constants');

        $request->validate([
            'avatar' => ['required', 'string'] // todo: make a rule that will check if it's in constants.
        ]);

        User::find(auth()->user()->id)->update(['avatar' => $request->avatar]);
    }
}