<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Activity;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AntelopeActivity extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Activity Controller
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
            'patrol_date' => ['required', 'date'],
            'start_time' => ['required', 'string'],
            'end_time' => ['required', 'string'],
            'type' => ['required', 'string', 'max:30'],
            'details' => ['required', 'string'],
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

        $log = Activity::create([
            'patrol_date' => date("Y-m-d", strtotime($data['patrol_date'])),
            'start_time' => date("H:i:s", strtotime($data['start_time'])),
            'end_time' => date("H:i:s", strtotime($data['end_time'])),
            'type' => $data['type'],
            'details' => $data['details'],
            'user_id' => Auth::user()->id,
        ]);

        return $log;
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

        $log = $this->create($request->all());

        return $this->submitted($request, $log);
    }

    /**
     * Construct Activity Page
     *
     * @return View
     */
    public function constructPage()
    {
        $constants = \Config::get('constants');

        return view('activity_database')->with('constants', $constants);
    }

    /**
     * Gets all activity in database
     *
     * @return View
     */
    public function passActivityData()
    {
    $query = Activity::query()
    ->select([
        'activity.id',
        'activity.user_id',
        'activity.patrol_date',
        'activity.start_time',
        'activity.end_time',
        'activity.details',
        'activity.type',
        'users.name',
    ])
    ->join('users', function($join) {
        $join->on('activity.user_id', '=', 'users.id');
    });

    return datatables($query)->toJson();
    }
}
