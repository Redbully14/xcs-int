<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Absence;
use App\Rules\DateValidation;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Http\Controllers\AntelopeCalculate;

class AntelopeAbsence extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Absence Controller
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
     * @category AntelopeAbsence
     * @version 1.0.0
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', new DateValidation($data['start_date'])],
            'forum_post' => ['required', 'url'],
        ]);
    }

    /**
     * Inserts and creates a new absence for the database
     *
     * @author Oliver G.
     * @param Array $data
     * @return App\Absence
     * @category AntelopeAbsence
     * @version 1.0.0
     */
    protected function create(array $data)
    {

        $absence = Absence::create([
            'start_date' => date("Y-m-d", strtotime($data['start_date'])),
            'end_date' => date("Y-m-d", strtotime($data['end_date'])),
            'forum_post' => $data['forum_post'],
            'user_id' => Auth::user()->id,
        ]);

        return $absence;
    }

    /**
     * Executes after an absence is created
     *
     * @author Oliver G.
     * @param Request $request
     * @param Request $log
     * @return void
     * @category AntelopeAbsence
     * @version 1.0.0
     */
    protected function submitted(Request $request, $log)
    {
        //
    }

    /**
     * Submits a new Absence Request for an insert into the database
     *
     * @author Oliver G.
     * @param Request $request
     * @return Function submitted($request, $absence)
     * @category AntelopeAbsence
     * @access Member
     * @version 1.0.0
     */
    public function submit(Request $request)
    {
        $url = $request['forum_post'];
        if (strpos($url, 'dojrp.com/forums/topic') !== false) {
            $url = explode('-', $url);
            $url = $url[0] . '-loa';
            $request['forum_post'] = $url;
        } else {
            $request['forum_post'] = null;
        }

        $this->validator($request->all())->validate();

        $absence = $this->create($request->all());

        return $this->submitted($request, $absence);
    }

    /**
     * Backend controller for the absence_database module
     *
     * @author Oliver G.
     * @return View
     * @category AntelopeAbsence
     * @access Staff
     * @version 1.0.0
     */
    public function view()
    {
        return view('absence_database')->with('constants', $this->constants);
    }

    /**
     * Backend sub-controller for the absence_database->archive module
     *
     * @author Oliver G.
     * @return View
     * @category AntelopeAbsence
     * @access Senior Staff
     * @version 1.0.0
     */
    public function archive()
    {
        return view('absence_database_archive')->with('constants', $this->constants);
    }

    /**
     * Constructs a DataTable for the absence table
     *
     * @author Oliver G.
     * @return Datatables
     * @param var $status
     * @category AntelopeAbsence
     * @access Staff
     * @version 1.0.0
     */
    public function passAbsenceDataTable($status)
    {
        $query = Absence::query()
        ->select([
            'absence.id',
            'absence.user_id',
            'absence.start_date',
            'absence.end_date',
            'absence.forum_post',
            'absence.status',
            'users.name',
            'users.department_id',
            'users.website_id'
        ])
        ->join('users', function($join) {
            $join->on('absence.user_id', '=', 'users.id');
        })->where('absence.status', '=', $status);

        return datatables($query)
        ->addColumn('name_department_id', function($row){
                    if ( $row->department_id == null ) {
                        return $row->name;
                    }
                    else return $row->name.' '.$row->department_id;})
        ->addColumn('start_end_date', function($row){
                    $start_date = strtotime($row->start_date);
                    $end_date = strtotime($row->end_date);

                    $duration = $end_date - $start_date;
                    $duration = BaseXCS::convertToDays($duration);

                    if ( $row->end_date == $row->start_date ) {

                        if(strtotime(Carbon::now()->toDateString()) > $end_date) {
                            return $row->start_date;
                        } else return $row->start_date;
                    }
                    else {
                        if(strtotime(Carbon::now()->toDateString()) > $end_date) {
                            return $row->start_date.' - '.$row->end_date;
                        } else return $row->start_date.' - '.$row->end_date.' ['.$duration.' days]';
                    }})
        ->addColumn('admin_approval', function($row) {
                    $start_date = strtotime($row->start_date);
                    $end_date = strtotime($row->end_date);
                    $duration = $end_date - $start_date;

                    if($duration >= $this->constants['calculation']['absence_admin_approval']) {
                        return true;
                    } else return false;})
        ->rawColumns(['forum_post'])
        ->toJson();
    }

    /**
     * Finds an Absence in the database and approves it
     *
     * @author Oliver G.
     * @return void
     * @param var $id
     * @category AntelopeAbsence
     * @access Staff
     * @version 1.0.0
     */
    public function approveAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 1;
        $absence->save();
    }

    /**
     * Finds an Absence in the database and archives it
     *
     * @author Oliver G.
     * @return void
     * @param var $id
     * @category AntelopeAbsence
     * @access Staff
     * @version 1.0.0
     */
    public function archiveAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 2;
        $absence->save();
    }

    /**
     * Finds an Absence in the database and queues
     *
     * @author Oliver G.
     * @return void
     * @param var $id
     * @category AntelopeAbsence
     * @access Staff
     * @version 1.0.0
     */
    public function queueAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 0;
        $absence->save();
    }
}
