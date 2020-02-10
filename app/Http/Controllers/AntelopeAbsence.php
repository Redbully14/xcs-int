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
     * Get a validator for an incoming log request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
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
     * Create a new log instance after validation
     *
     * @param  array  $data
     * @return \App\User
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
     * The activity log has been registered
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function submitted(Request $request, $log)
    {
        //
    }

    /**
     * Handle an activity log submit for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Gets all activity in database
     *
     * @return View
     */
    public function view()
    {
        $constants = \Config::get('constants');

        return view('absence_database')->with('constants', $constants);
    }

     /**
     * Gets all activity in database
     *
     * @return View
     */
    public function archive()
    {
        $constants = \Config::get('constants');

        return view('absence_database_archive')->with('constants', $constants);
    }

    /**
     * Generates all absences in a table that has the status as unreviewed
     *
     * @return DataTable
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
                    $constants = \Config::get('constants');
                    $start_date = strtotime($row->start_date);
                    $end_date = strtotime($row->end_date);
                    $duration = $end_date - $start_date;

                    if($duration >= $constants['calculation']['absence_admin_approval']) {
                        return true;
                    } else return false;})
        ->rawColumns(['forum_post'])
        ->toJson();
    }

    /**
     * Changes a status of an absence to approved
     *
     * @return void
     */
    public function approveAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 1;
        $absence->save();
    }

    /**
     * Changes a status of an absence to archived
     *
     * @return DataTable
     */
    public function archiveAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 2;
        $absence->save();
    }

    /**
     * Changes a status of an absence to unreviewed
     *
     * @return DataTable
     */
    public function queueAbsence($id)
    {
        $absence = Absence::find($id);
        $absence->status = 0;
        $absence->save();
    }
}
