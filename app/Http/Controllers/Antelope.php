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
use App\Http\Controllers\AntelopeCalculate;
use App\Http\Controllers\BaseXCS;

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

    /**
     * Constructs a user's profile
     *
     * @return View
     */
    public function getProfile($id)
    {
        $constants = \Config::get('constants');

        $user_data = User::find($id);
        $role = User::find($id)->getRoles();

        // this gonna be a long list...
        $calculations = [
            'last_timestamp' => AntelopeCalculate::get_last_timestamp($id),
            'last_seen' => AntelopeCalculate::get_last_seen($id),
            'department_status' => AntelopeCalculate::get_department_status($id),
            'total_patrol_logs' => AntelopeCalculate::get_total_patrol_logs($id),
            'total_patrol_hours' => AntelopeCalculate::get_total_patrol_hours($id),
            'this_month_logs' => AntelopeCalculate::get_month_patrol_logs($id, 0),
            'this_month_hours' => AntelopeCalculate::get_month_patrol_hours($id, 0),
            'one_week_logs' => AntelopeCalculate::get_ctime_patrol_logs($id, 'custom_one_week'),
            'one_week_hours' => AntelopeCalculate::get_ctime_patrol_hours($id, 'custom_one_week'),
            'one_month_logs' => AntelopeCalculate::get_ctime_patrol_logs($id, 'custom_one_month'),
            'one_month_hours' => AntelopeCalculate::get_ctime_patrol_hours($id, 'custom_one_month'),
            'two_month_logs' => AntelopeCalculate::get_ctime_patrol_logs($id, 'custom_two_month'),
            'two_month_hours' => AntelopeCalculate::get_ctime_patrol_hours($id, 'custom_two_month'),
            'requirements' => AntelopeCalculate::get_month_requirements($id, 0),
        ];

        return view('user_profile')->with('user_data', $user_data)
                                   ->with('constants', $constants)
                                   ->with('role', $role)
                                   ->with('calculations', $calculations);
    }
}