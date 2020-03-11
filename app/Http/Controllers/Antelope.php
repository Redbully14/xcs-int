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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Promotion;
use App\Notifications\NewUnitNumber;
use App\Notifications\CustomSANotify;

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
            $dashboard_calculations['needs_approval'] = AntelopeCalculate::absences_needing_approval();
            $dashboard_calculations['invalidated_logs'] = AntelopeCalculate::activity_flagged();
            $dashboard_calculations['overdue_absences'] = AntelopeCalculate::overdue_absences();
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
     * Backend sub-controller for the superadmin->icons2 module
     *
     * @author Oliver G.
     * @return View
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superAdminIcons2()
    {
        return view('developers.superadmin_icons2')->with('constants', $this->constants);
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

        Log::notice(auth()->user()->id.' is entering godmode for user '.$request->id);

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

    /**
     * Investigative Search Function
     *
     * @author Oliver G.
     * @return view
     * @category Antelope
     * @access DOJ Admin / Internal Affairs
     * @version 1.0.0
     */
    public function investigativeSearch()
    {

        $users = User::all();
        $members_array = array();

        foreach ($users as $user) {
            $name = $user->name;
            $department_id = $user->department_id;
            $website_id = $user->website_id;

            if ($department_id == null) {
                $member = $website_id.' - '.$name;
            } else {
                $member = $website_id.' - '.$name.' '.$department_id;
            }

            $members_array[url("/investigative_search/".env('ROUTE_INVESTIGATIVE_SEARCH_KEY', 'NO_KEY_SET')."/profile/{$user->id}")] = $member;
        }

        if ((auth()->user()->rank == 'other_admin' or auth()->user()->rank == 'ia') and auth()->user()->level() >= $this->constants['access_level']['guest']) {
            return view('investigative_search')->with('constants', $this->constants)
                                               ->with('members_array', $members_array);
        }
    }

    /**
     * Investigative Search Function - Profile
     *
     * @author Oliver G.
     * @return view
     * @category Antelope
     * @access DOJ Admin / Internal Affairs
     * @version 1.0.0
     */
    public function investigativeSearch_search($id)
    {
        if ((auth()->user()->rank == 'other_admin' or auth()->user()->rank == 'ia') and auth()->user()->level() == $this->constants['access_level']['guest']) {
            Log::warning("User id ".auth()->user()->id." is accessing data via the investigative search tool for user id ".$id.".");
            return $this->getProfile($id);
        } else Log::critical("User id ".auth()->user()->id.' attempted to use the investigative search tool without the proper access.');
    }

    /**
     * Backend controller for the internal_roster module
     *
     * @author Oliver G.
     * @return View
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function internalRoster_view()
    {
        return view('internal_roster')->with('constants', $this->constants);
    }

    /**
     * Backend controller for editing a person's name on the internal roster
     *
     * @author Oliver G.
     * @param Request $request
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function internalRoster_edit_name(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $user = User::find($request->route('user'));
        $user->name = $request['name'];
        $user->save();

        return;
    }

    /**
     * Backend controller for editing a person's website ID on the internal roster
     *
     * @author Oliver G.
     * @param Request $request
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function internalRoster_edit_websiteid(Request $request)
    {
        $request->validate([
            'callsign' => ['required', 'integer']
        ]);

        $user = User::find($request->route('user'));
        $user->website_id = $request['website_id'];
        $user->save();

        return;
    }

    /**
     * Backend controller for editing a person's callsign on the internal roster
     *
     * @author Oliver G.
     * @param Request $request
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function internalRoster_edit_callsign(Request $request)
    {
        $request->validate([
            'callsign' => ['required', 'string', 'max:30']
        ]);

        $user = User::find($request->route('user'));

        $user->notify(new NewUnitNumber($user->department_id, $request['callsign']));

        $user->department_id = $request['callsign'];
        $user->save();

        return;
    }

    /**
     * Backend controller for editing a person's rank on the internal roster
     *
     * @author Oliver G.
     * @param Request $request
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function internalRoster_edit_rank(Request $request)
    {
        $request->validate([
            'rank' => ['required', 'string', 'max:30']
        ]);

        $user = User::find($request->route('user'));

        if($this->constants['rank_level'][$user->rank] < $this->constants['rank_level'][$request['rank']]) {
            $user->notify(new Promotion($request['rank']));
        }

        $user->rank = $request['rank'];
        $user->save();

        return;
    }

    /**
     * Send a notification to all users on the website
     *
     * @author Oliver G.
     * @return redirect
     * @category Antelope
     * @access SuperAdmin
     * @version 1.0.0
     */
    public function superAdminNotify(Request $request)
    {
        Log::notice(auth()->user()->id." has sent a notification to all members on the website.");

        $users = User::where('antelope_status', '=', true)->get();

        Notification::send($users, new CustomSANotify($request['title'], $request['text'], $request['icon'], $request['color']));

        return redirect()->route('superadmin');
    }
}
