<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Activity;
use App\Rules\TimeValidation;
use App\Rules\DateValidation;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;

class AntelopeActivity extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Activity Controller
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
     * Validates request before running main function
     *
     * @author Oliver G.
     * @param Array $data
     * @return Illuminate\Support\Facades\Validator
     * @category AntelopeActivity
     * @version 1.0.0
     */
    protected function validator(array $data)
    {
        if (is_null($data['patrol_end_date'])) {
            $data['patrol_end_date'] = $data['patrol_start_date'];
        }

        if ($data['flag'] === "true") {
            $data['flag'] = true;
        } else if ($data['flag'] === "false") {
            $data['flag'] = false;
        }

        if (is_null($data['flag_reason'])) {
            $data['flag_reason'] = "";
        }

        return Validator::make($data, [
            'patrol_start_date' => ['required', 'date'],
            'patrol_end_date' => ['date', new DateValidation($data['patrol_start_date'])],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string', new TimeValidation($data['start_time'], $data['patrol_start_date'], $data['patrol_end_date'])],
            'type' => ['required', 'string', 'max:30'],
            'details' => ['required', 'string'],
            'patrol_area' => ['required', 'array', 'min:1'],
            'patrol_area.*' => ['required', 'string'],
            'patrol_priorities' => ['required', 'integer', 'min:0', 'max:20'],
            'flag' => ['required', 'boolean'],
            'flag_reason' => ['string']
        ]);
    }

    /**
     * Inserts and creates a new activity for the database
     *
     * @author Oliver G.
     * @param Array $data
     * @return App\Activity
     * @category AntelopeActivity
     * @version 1.0.0
     */
    protected function create(array $data)
    {
        if (is_null($data['patrol_end_date'])) {
            $data['patrol_end_date'] = $data['patrol_start_date'];
        }
        $data = $this->convertTimezone($data);

        if ($data['flag'] === "true") {
            $data['flag'] = true;
        } else if ($data['flag'] === "false") {
            $data['flag'] = false;
        }

        if (is_null($data['flag_reason'])) {
            $data['flag_reason'] = "";
        }

        $now = Carbon::now(User::find(Auth::user()->id)->timezone)->tz('UTC');
        $anHour = $now->addHour();
        $start = new DateTime($data['patrol_start_date'] . 'T' . $data['start_time']);
        $end = new DateTime($data['patrol_end_date'] . 'T' . $data['end_time']);
        $diff = $end->diff($start);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);
        $auto_flag = false;
        $auto_flag_reason = "";

        if ($hours >= $this->constants['soft_patrol_hour_limit']) {
            $auto_flag = true;
            $auto_flag_reason = "Patrol is " . $this->constants['soft_patrol_hour_limit'] . "+ hours in length.";
        }

        if ($start > $anHour) {
            $auto_flag = true;
            if ($auto_flag_reason === "") {
                $auto_flag_reason = "Patrol starts in the future.";
            } else {
                $auto_flag_reason = $auto_flag_reason . " Patrol starts in the future.";
            }
        }

        if ($end > $anHour) {
            $auto_flag = true;
            if ($auto_flag_reason === "") {
                $auto_flag_reason = "Patrol ends in the future.";
            } else {
                $auto_flag_reason = $auto_flag_reason . " Patrol ends in the future.";
            }
        }

        $log = Activity::create([
            'patrol_start_date' => date("Y-m-d", strtotime($data['patrol_start_date'])),
            'patrol_end_date' => date("Y-m-d", strtotime($data['patrol_end_date'])),
            'start_time' => date("H:i:s", strtotime($data['start_time'])),
            'end_time' => date("H:i:s", strtotime($data['end_time'])),
            'total_time' => $hours . " hours",
            'type' => $data['type'],
            'details' => $data['details'],
            'user_id' => Auth::user()->id,
            'patrol_area' => json_encode($data['patrol_area']),
            'priorities' => $data['patrol_priorities'],
            'flag' => json_encode([[$data['flag'], $auto_flag, false], [$data['flag_reason'], $auto_flag_reason, ["", ""]]])
        ]);

        return $log;
    }

    /**
     * Executes after an activity is created
     *
     * @author Oliver G.
     * @param Request $request
     * @param Request $log
     * @return void
     * @category AntelopeActivity
     * @version 1.0.0
     */
    protected function submitted(Request $request, $log)
    {
        //
    }

    /**
     * Converts the activity log's time to the system's time
     *
     * @author Oliver G.
     * @param Array $data
     * @return var $data
     * @category AntelopeActivity
     * @version 1.0.0
     */
    protected function convertTimezone(array $data)
    {
        $patrol_start_date = $data['patrol_start_date'];
        $start_time = $data['start_time'];
        $patrol_end_date = $data['patrol_end_date'];
        $end_time = $data['end_time'];

        $start_date_time = date('Y-m-d H:i:s', strtotime("$patrol_start_date $start_time"));
        $end_date_time = date('Y-m-d H:i:s', strtotime("$patrol_end_date $end_time"));

        $start_date_time = BaseXCS::convertTimezone(Auth::user()->id, $start_date_time);
        $end_date_time = BaseXCS::convertTimezone(Auth::user()->id, $end_date_time);

        $data['patrol_start_date'] = date('Y-m-d', strtotime($start_date_time));
        $data['start_time'] = date('H:i:s', strtotime($start_date_time));

        $data['patrol_end_date'] = date('Y-m-d', strtotime($end_date_time));
        $data['end_time'] = date('H:i:s', strtotime($end_date_time));

        return $data;
    }

    /**
     * Submits a new Activity Request for an insert into the database
     *
     * @author Oliver G.
     * @param Request $request
     * @return Function submitted($request, $log)
     * @category AntelopeActivity
     * @access Member
     * @version 1.0.0
     */
    public function submit(Request $request)
    {
        $this->validator($request->all())->validate();

        $log = $this->create($request->all());

        return $this->submitted($request, $log);
    }

    /**
     * Validates an edit request before running main function
     *
     * @author Oliver G.
     * @param Array $data
     * @return Illuminate\Support\Facades\Validator
     * @category AntelopeActivity
     * @version 1.0.0
     */
    protected function edit_validator(array $data)
    {

        return Validator::make($data, [
            'type' => ['required', 'string'],
            'patrol_start_date' => ['required', 'date'],
            'patrol_end_date' => ['nullable', 'date', new DateValidation($data['patrol_start_date'])],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string', new TimeValidation($data['start_time'], $data['patrol_start_date'], $data['patrol_end_date'])],
            'details' => ['required', 'string'],
            'patrol_area' => ['required', 'array', 'min:1'],
            'patrol_area.*' => ['required', 'string'],
            'patrol_priorities' => ['required', 'integer', 'min:0', 'max:20'],
        ]);
    }

    /**
     * Edits an already established activity log
     *
     * @author Oliver G.
     * @param Request $request
     * @return void
     * @category AntelopeActivity
     * @access SeniorStaff
     * @version 1.0.0
     */
    public function edit(Request $request)
    {
        $log = Activity::find($request->route('id'));

        $this->edit_validator($request->all())->validate();

        $start = new DateTime($request['patrol_start_date'] . 'T' . $request['start_time']);
        $end = new DateTime($request['patrol_end_date'] . 'T' . $request['end_time']);
        $diff = $end->diff($start);
        $hours = $diff->h;
        $hours = $hours + ($diff->days * 24);

        $log->type = $request['type'];
        $log->patrol_start_date = $request['patrol_start_date'];
        $log->patrol_end_date = $request['patrol_end_date'];
        $log->start_time = $request['start_time'];
        $log->end_time = $request['end_time'];
        $log->total_time = $hours . " hours";
        $log->details = $request['details'];
        $log->patrol_area = $request['patrol_area'];
        $log->priorities = $request['patrol_priorities'];
        $log->save();

        return;
    }

    /**
     * Backend controller for the absence_database module
     *
     * @author Oliver G.
     * @return View
     * @access Staff
     * @category AntelopeActivity
     * @version 1.0.0
     */
    public function constructPage()
    {
        return view('activity_database')->with('constants', $this->constants);
    }

    /**
     * Constructs a DataTable for the activity table
     *
     * @author Oliver G.
     * @return Datatables
     * @category AntelopeActivity
     * @access Staff
     * @version 1.0.0
     */
    public function passActivityData()
    {
    $query = Activity::query()
    ->select([
        'activity.id',
        'activity.user_id',
        'activity.patrol_start_date',
        'activity.patrol_end_date',
        'activity.start_time',
        'activity.end_time',
        'activity.total_time',
        'activity.details',
        'activity.patrol_area',
        'activity.priorities',
        'activity.type',
        'activity.flag',
        'users.name',
        'users.department_id',
        'users.website_id'
    ])
    ->join('users', function($join) {
        $join->on('activity.user_id', '=', 'users.id');
    });

    return datatables($query)
    ->addColumn('name_department_id', function($row){
                if ( $row->department_id == null ) {
                    return $row->name;
                }
                else return $row->name.' '.$row->department_id;})
    ->addColumn('patrol_start_end_date', function($row){
                if ( $row->patrol_end_date == null or $row->patrol_end_date == $row->patrol_start_date ) {
                    return $row->patrol_start_date;
                }
                else return $row->patrol_start_date.' - '.$row->patrol_end_date;})
    ->rawColumns(['details'])
    ->toJson();
    }

    /**
     * Passes a singular instance for the activity table
     *
     * @author Oliver G.
     * @param var $id
     * @return App\Activity
     * @category AntelopeActivity
     * @access SIT
     * @version 1.0.0
     */
    public function passActivityInstance($id)
    {
        if(Auth::user()->level() >= $this->constants['access_level']['sit'] or Auth::user()->id == Activity::find($id)->user_id or Auth::user()->rank == 'ia' or Auth::user()->rank == 'other_admin') {
            $log = Activity::find($id);

            $log->user_name = User::find($log['user_id'])->name;
            $log->department_id = User::find($log['user_id'])->department_id;
            $log->website_id = User::find($log['user_id'])->website_id;

            return $log;
        } else return 'noob hax0r';
    }

    /**
     * Edits a specific activity log's flags in the controller
     *
     * @author Christopher M.
     * @param Request $request
     * @return void
     * @category AntelopeActivity
     * @access Staff
     * @version 1.0.0
     */
    public function editActivityFlagInstance(Request $request)
    {
        if(Auth::user()->level() >= $this->constants['access_level']['staff']) {
            $log = Activity::find($request->route('id'));

            $temp_array = [];
            $temp_array['self_resolve_reason'] = $request->self_resolve_reason;
            $temp_array['auto_resolve_reason'] = $request->auto_resolve_reason;

            if (is_null($temp_array['self_resolve_reason'])) {
                $temp_array['self_resolve_reason'] = "No details.";
            }
            if (is_null($temp_array['auto_resolve_reason'])) {
                $temp_array['auto_resolve_reason'] = "No details.";
            }

            Validator::make($temp_array, [
                'self_resolve_reason' => ['required', 'string'],
                'auto_resolve_reason' => ['required', 'string']
            ]);

            $oldFlag = json_decode($log->flag);
            $log->flag = json_encode([[$oldFlag[0][0], $oldFlag[0][1], true],[$oldFlag[1][0], $oldFlag[1][1], [$temp_array['self_resolve_reason'], $temp_array['auto_resolve_reason']]]]);
            $log->save();

            return;
        } else return 'noob hax0r';
    }

    /**
     * Passes a singular flag instance for the activity table
     *
     * @author Christopher M.
     * @param var $id
     * @return var $log->flag
     * @category AntelopeActivity
     * @access Staff
     * @version 1.0.0
     */
    public function passActivityFlagInstance($id)
    {
        if(Auth::user()->level() >= $this->constants['access_level']['staff'] or Auth::user()->id == Activity::find($id)->user_id) {
            $log = Activity::find($id);

            return $log->flag;
        } else return 'noob hax0r';
    }


    /**
     * Constructs a DataTable on a specific user for the activity table
     *
     * @author Oliver G.
     * @param var $id
     * @return Datatables
     * @category AntelopeActivity
     * @access SIT
     * @version 1.0.0
     */
    protected function activityData($id)
    {
        if(Auth::user()->level() >= $this->constants['access_level']['sit'] or Auth::user()->id == $id or Auth::user()->rank == 'ia' or Auth::user()->rank == 'other_admin') {
            $query = Activity::query()
            ->select([
                'id',
                'user_id',
                'patrol_start_date',
                'patrol_end_date',
                'start_time',
                'end_time',
                'details',
                'patrol_area',
                'priorities',
                'type',
            ])->where('user_id', '=', $id);

            return Datatables($query)
            ->addColumn('patrol_start_end_date', function($row){
                    if ( $row->patrol_end_date == null or $row->patrol_end_date == $row->patrol_start_date ) {
                        return $row->patrol_start_date;
                    }
                    else return $row->patrol_start_date.' - '.$row->patrol_end_date;})
            ->addColumn('patrol_duration', function($row){
                    if ( $row->patrol_end_date == null or $row->patrol_end_date == $row->patrol_start_date ) {
                        $start = Carbon::parse($row->start_time);
                        $end = Carbon::parse($row->end_time);
                        $totalDuration = $end->diffInSeconds($start);
                        return gmdate('H:i:s', $totalDuration);
                    }
                    else {
                        $start_date_time = date('Y-m-d H:i:s', strtotime("$row->patrol_start_date $row->start_time"));
                        $end_date_time = date('Y-m-d H:i:s', strtotime("$row->patrol_end_date $row->end_time"));

                        $start_date_time = strtotime($start_date_time);
                        $end_date_time = strtotime($end_date_time);

                        $total_duration = $end_date_time - $start_date_time;

                        return BaseXCS::convertToDuration($total_duration);
                    };})
            ->rawColumns(['details'])
            ->toJson();
        } else return 'pwnd hax0r';
    }

    /**
     * Soft Deletes a patrol log
     *
     * @author Oliver G.
     * @param var $id
     * @category AntelopeActivity
     * @access Senior Staff
     * @version 1.0.0
     */
    protected function softDelete($id)
    {
        Activity::destroy($id);

        return;
    }
}
