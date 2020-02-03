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
            'forum_post' => ['required', 'string'],
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
                    if ( $row->start_date == null or $row->end_date == $row->start_date ) {
                        return $row->start_date;
                    }
                    else return $row->start_date.' - '.$row->end_date;})
        ->rawColumns(['forum_post'])
        ->toJson();
    }
}
