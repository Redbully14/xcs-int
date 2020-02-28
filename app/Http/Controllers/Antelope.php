<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\User;
use App\Feedback;
use App\Settings;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\AntelopeCalculate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Antelope extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Main Controller
    |--------------------------------------------------------------------------
    |
    */

    public $constants;

    /**
     * Executes before running the main controllers
     *
     * @author Oliver G.
     * @param
     * @return void
     * @access Auth
     * @version 1.0.0
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->constants = \Config::get('constants');
    }

    /**
     * Backend controller for the dashboard module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @version 1.0.0
     */
    public function dashboard()
    {
        $id = Auth::user()->id;

        // Feedback System
        $feedback = Feedback::where('user_id', '=', Auth::user()->id)->get();

        if ($feedback->first() == null) {
            $feedback = false;
        } else $feedback = true;

        // To disable feedbacks, uncomment this line:
        //$feedback = true;

        $dashboard_calculations = [];

        if(auth()->user()->exempt_requirements == false) {

            $dashboard_calculations['requirements'] = AntelopeCalculate::amount_to_requirements($id);
            $dashboard_calculations['this_month_logs'] = AntelopeCalculate::get_month_patrol_logs($id, 0);
            $dashboard_calculations['this_month_hours'] = AntelopeCalculate::get_month_patrol_hours($id, 0);
            
            if($dashboard_calculations['this_month_hours'] == '-') {
                $dashboard_calculations['this_month_logs'] = 0;
                $dashboard_calculations['this_month_hours'] = 0;
            } else {
                $dashboard_calculations['this_month_hours'] = BaseXCS::durationToSeconds($dashboard_calculations['this_month_hours']);
                $dashboard_calculations['this_month_hours'] = (int)floor($dashboard_calculations['this_month_hours'] / 3600);
            }

        }

        if(auth()->user()->level() >= $this->constants['access_level']['staff']) {
            $dashboard_calculations['needs_approval'] = AntelopeCalculate::absences_needing_approval($id);
            $dashboard_calculations['invalidated_logs'] = AntelopeCalculate::activity_flagged($id);
        }

        $quicklinks = Settings::where('type', '=', 'quicklink')->get();

        $quicklinks = json_decode($quicklinks);
        $array = [];

        $count = 0;

        foreach($quicklinks as $quicklink) {
            $array[$count] = json_decode($quicklink->metadata);
            $count++;
        }

        return view('dashboard')->with('constants', $this->constants)
                                ->with('feedback', $feedback)
                                ->with('calculations', $dashboard_calculations)
                                ->with('quicklinks', $array);
    }

    /**
     * Backend controller for the member_admin module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @version 1.0.0
     */
    public function memberAdmin()
    {
        return view('member_admin')->with('constants', $this->constants);
    }

    /**
     * Constructs the users table
     *
     * @author Oliver G.
     * @return Datatables
     * @category Antelope
     * @access Admin
     * @version 1.0.0
     */
    public function passUserData()
    {
        return Datatables::of(User::query()->with('roles'))->make(true);
    }

    /**
     * Backend controller for the account_settings module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @version 1.0.0
     */
    public function accountSettings()
    {
        return view('account_settings')->with('constants', $this->constants);
    }

    /**
     * Updates a user's avatar upon request
     *
     * @author Oliver G.
     * @return void
     * @param Request
     * @category Antelope
     * @version 1.0.0
     */
    public function setAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'string'] // todo: make a rule that will check if it's in constants.
        ]);

        User::find(auth()->user()->id)->update(['avatar' => $request->avatar]);
    }

    /**
     * Sets a user's timezone upon request
     *
     * @author Oliver G.
     * @return void
     * @param Request
     * @category Antelope
     * @version 1.0.0
     */
    public function setTimezone(Request $request)
    {
        $request->validate([
            'timezone' => ['required', 'string'] // todo: make a rule that will check if it's in constants.
        ]);

        User::find(auth()->user()->id)->update(['timezone' => $request->timezone]);
    }

    /**
     * Calculates all the essential profile calculations to construct and return the data to the user
     *
     * @author Oliver G.
     * @return variable ($calculations)
     * @param $id (user id)
     * @category Antelope
     * @version 1.0.0
     */
    public function getProfileCalculations($id)
    {
        return $calculations = [
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
            'total_active_discipline' => AntelopeCalculate::get_total_active_disciplines($id),
            'total_discipline' => AntelopeCalculate::get_total_disciplines($id),
            'warnings_active_discipline' => AntelopeCalculate::get_custom_active_disciplines($id, 1),
            'warnings_total_discipline' => AntelopeCalculate::get_custom_disciplines($id, 1),
            '90s_active_discipline' => AntelopeCalculate::get_custom_active_disciplines($id, 2),
            '90s_total_discipline' => AntelopeCalculate::get_custom_disciplines($id, 2),
            '93s_active_discipline' => AntelopeCalculate::get_custom_active_disciplines($id, 3),
            '93s_total_discipline' => AntelopeCalculate::get_custom_disciplines($id, 3),
            'patrol_restriction' => AntelopeCalculate::chk_patrol_restriction($id),
            'absence_status' => AntelopeCalculate::absence_status($id),
        ];
    }

    /**
     * Backend controller for the user_profile module
     *
     * @author Oliver G.
     * @return View
     * @param $id (user id)
     * @category Antelope
     * @access SIT
     * @version 1.0.0
     */
    public function getProfile($id)
    {
        $user_data = User::find($id);
        $role = User::find($id)->getRoles();

        // this gonna be a long list...
        $calculations = self::getProfileCalculations($id);

        return view('user_profile')->with('user_data', $user_data)
                                   ->with('constants', $this->constants)
                                   ->with('role', $role)
                                   ->with('calculations', $calculations);
    }

    /**
     * Backend controller for the personal_profile module
     *
     * @author Oliver G.
     * @return void
     * @param $id (user id)
     * @category Antelope
     * @version 1.0.0
     */
    public function myProfile()
    {
        $id = auth()->user()->id;
        $user_data = User::find($id);
        $role = User::find($id)->getRoles();

        if(auth()->user()->level() >= $this->constants['access_level']['sit']) {
            return self::getProfile($id);
        }

        else {

            $calculations = self::getProfileCalculations($id);

            return view('personal_profile')->with('user_data', $user_data)
                                       ->with('constants', $this->constants)
                                       ->with('role', $role)
                                       ->with('calculations', $calculations);
        }
    }

    /**
     * Backend controller for the superadmin module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superAdmin()
    {
        return view('superadmin')->with('constants', $this->constants);
    }

    /**
     * Backend sub-controller for the superadmin->icons module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superAdminIcons()
    {
        return view('developers.superadmin_icons')->with('constants', $this->constants);
    }

    /**
     * Enter and godmode into an active user's profile
     *
     * @author Oliver G.
     * @return json
     * @param Request
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superAdminGodmode(Request $request)
    {
        auth()->user()->impersonate(User::find($request->id));

        return response()->json([
          'redirect_to' => route('dashboard')
        ]); 
    }

    /**
     * Exit godmode whilst actively impersonating another user
     *
     * @author Oliver G.
     * @return redirect
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superStopGodmode()
    {
        auth()->user()->leaveImpersonation();

        return redirect()->route('superadmin');
    }

    /**
     * Controls the submit function of the feedback form
     *
     * @author Oliver G.
     * @param Request $request
     * @return void
     * @category Antelope
     * @version 1.0.0
     */
    public function feedbackSubmit(Request $request)
    {
        $data = ($request->all());

        Validator::make($data, [
            'score' => ['required', 'integer'],
            'feedback' => ['nullable', 'string']
        ]);

        Feedback::create([
            'user_id' => Auth::user()->id,
            'score' => $data['score'],
            'feedback' => $data['feedback'],
        ]);
        
        return;
    }

    /**
     * Backend controller for the settings_admin module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @version 1.0.0
     */
    public function adminSettings_view()
    {
        $quicklinks = Settings::where('type', '=', 'quicklink')->get();

        $quicklinks = json_decode($quicklinks);
        $array = [];

        $count = 0;

        foreach($quicklinks as $quicklink) {
            $array[$count] = json_decode($quicklink->metadata);
            $array[$count]["id"] = $quicklink->id;
            $count++;
        }

        return view('settings_admin')->with('constants', $this->constants)
                                     ->with('quicklinks', $array);
    }

    /**
     * Controls the submit function of the Quicklink form
     *
     * @author Oliver G.
     * @param Request $request
     * @return void
     * @category Antelope
     * @version 1.0.0
     */
    public function adminSettings_addQuickLink(Request $request)
    {
        $data = ($request->all());

        Validator::make($data, [
            'type' => ['required', 'string'],
            'title' => ['required', 'string'],
            'link' => ['required', 'url'],
        ]);

        $data = json_encode([$data['type'], $data['title'], $data['link']]);

        Settings::create([
            'user_id' => Auth::user()->id,
            'type' => 'quicklink',
            'metadata' => $data,
        ]);

        return;
    }

    /**
     * Controls the manage function of the Quicklink form
     *
     * @author Oliver G. & Christopher M.
     * @param Request $request
     * @return void
     * @category Antelope
     * @version 1.0.1
     */
    public function adminSettings_manageQuickLink(Request $request)
    {
        $data = ($request->all());
        if (!empty($data)) {
            $data = $data['data'];

            foreach ($data as $key) {
                Validator::make($key, [
                    0 => ['required', 'string'],
                    1 => ['required', 'string'],
                    2 => ['required', 'url'],
                    3 => ['required', 'integer'],
                ]);

                $id = $key[3];
                $key = json_encode([$key[0], $key[1], $key[2]]);

                Settings::find($id)->update(['metadata' => $key]);
            }

            return;
        } else {
            return response()->json([
                'error' => 'Not sure how, but you really messed this bit up not found'
            ], 400);
        }
    }
}
