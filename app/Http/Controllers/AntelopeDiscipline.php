<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Discipline;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Http\Controllers\AntelopeCalculate;

class AntelopeDiscipline extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Discipline Controller
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
     * Construct Discipline Page
     *
     * @return View
     */
    public function constructPage()
    {
        $constants = \Config::get('constants');

        return view('discipline_database')->with('constants', $constants);
    }

    /**
     * Construct Discipline Table
     *
     * @return View
     */
    public function constructDisciplineTable()
    {
	    $query = Discipline::query()
	    ->leftJoin('users as t1', 'discipline.user_id', '=', 't1.id')
	    ->leftJoin('users as t2', 'discipline.issued_by', '=', 't2.id')
	    ->leftJoin('users as t3', 'discipline.overturned_by', '=', 't3.id')
	    ->select([
	        'discipline.id as discipline_id',
	        'discipline.user_id as issued_to',
	        'discipline.issued_by as issued_by',
	        'discipline.discipline_date as discipline_date',
	        'discipline.type as discipline_type',
	        'discipline.details as discipline_details',
	        'discipline.overturned as discipline_overturned',
	        'discipline.overturned_by as discipline_overturned_by',
	        'discipline.overturned_date as discipline_overturned_date',
	        'discipline.disputed as discipline_disputed',
	        'discipline.disputed_date as discipline_disputed_date',
	        't1.name as issued_to_name',
	        't1.department_id as issued_to_department_id',
	        't1.website_id as issued_to_website_id',
	        't2.name as issued_by_name',
	        't2.department_id as issued_by_department_id',
	        't2.website_id as issued_by_website_id',
	        't3.name as overturned_by_name',
	        't3.department_id as overturned_by_department_id',
	        't3.website_id as overturned_by_website_id',
	    ]);

	    return datatables($query)
	    ->editColumn('issued_to', function($row){
	                if ( $row->issued_to_department_id == null ) {
	                    return $row->issued_to_name;
	                }
	                else return $row->issued_to_name.' '.$row->issued_to_department_id;})
	    ->editColumn('issued_by', function($row){
	                if ( $row->issued_by_department_id == null ) {
	                    return $row->issued_by_name;
	                }
	                else return $row->issued_by_name.' '.$row->issued_by_department_id;})
	    ->editColumn('discipline_overturned_by', function($row){
	                if ( $row->overturned_by_department_id == null ) {
	                    return $row->overturned_by_name;
	                }
	                else return $row->overturned_by_name.' '.$row->overturned_by_department_id;})
	    ->editColumn('discipline_type', function($row){
	    			$constants = \Config::get('constants');
	                return $constants['disciplinary_actions'][$row->discipline_type];})
        ->addColumn('discipline_status', function($row){
                    $status = AntelopeCalculate::discipline_status($row->discipline_id);
                    $constants = \Config::get('constants');
                    return $constants['disciplinary_action_status'][$status];})
		->filterColumn('discipline_id', function($query, $keyword) {
					$constants = \Config::get('constants');
					$prefix = $constants['global_id']['disciplinary_action'];
					if (substr($keyword, 0, strlen($prefix)) == $prefix) {
					    $keyword = substr($keyword, strlen($prefix));
					}
					$sql = "REPLACE(discipline.id, '".$constants['global_id']['disciplinary_action']."', '')  like ?";
	                $query->whereRaw($sql, ["%{$keyword}%"]);
	               	})
		->filterColumn('issued_to', function($query, $keyword) {
					if (preg_match('/[0-9]/', $keyword)) {
						$sql = "CONCAT(t1.name,' ',t1.department_id)  like ?";
		                $query->whereRaw($sql, ["%{$keyword}%"]);
					} else {
						$sql = "CONCAT(t1.name)  like ?";
	                	$query->whereRaw($sql, ["%{$keyword}%"]);
					}
	                })
		->filterColumn('issued_by', function($query, $keyword) {
					if (preg_match('/[0-9]/', $keyword)) {
						$sql = "CONCAT(t2.name,' ',t2.department_id)  like ?";
		                $query->whereRaw($sql, ["%{$keyword}%"]);
					} else {
						$sql = "CONCAT(t2.name)  like ?";
	                	$query->whereRaw($sql, ["%{$keyword}%"]);
					}
	                })
        ->rawColumns(['discipline.details'])
	    ->toJson();
    }

    /**
     * Get a validator for an incoming discipline request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'issued_to' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'type' => ['required', 'integer'],
            'details' => ['required', 'string'],
            'custom_expiry_date' => ['nullable', 'date'],
        ]);
    }

    /**
     * Get a validator for an incoming edit discipline request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function editValidator(array $data)
    {

        $data['overturned'] = $data['overturned'] ? true : false;
        $data['disputed'] = $data['disputed'] ? true : false;

        return Validator::make($data, [
            'issued_by' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'type' => ['required', 'integer'],
            'details' => ['required', 'string'],
            'overturned_by' => ['nullable', 'integer'],
            'overturned_date' => ['nullable', 'date'],
            'disputed_date' => ['nullable', 'date'],
            'disputed' => ['required', 'boolean'],
            'overturned' => ['required', 'boolean'],
            'custom_expiry_date' => ['nullable', 'date'],
        ]);
    }

    /**
     * Create a new discipline instance after validation
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['custom_expiry_date'] == null) {
             $custom_expiry_date = null;
        } else $custom_expiry_date = date("Y-m-d", strtotime($data['custom_expiry_date']));
        
        $discipline = Discipline::create([
        	'user_id' => $data['issued_to'],
        	'issued_by' => auth()->user()->id,
        	'discipline_date' => date("Y-m-d", strtotime($data['date'])),
        	'type' => $data['type'],
        	'details' => $data['details'],
            'custom_expiry_date' => $custom_expiry_date,
        ]);

        return $discipline;
    }

    /**
     * The discipline log has been registered
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function submitted(Request $request, $discipline)
    {
        //
    }

    /**
     * Handle an discipline submit for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        $this->validator($request->all())->validate();

        $discipline = $this->create($request->all());

        return $this->submitted($request, $discipline);
    }

    /**
     * Gets specific discipline instance
     *
     * @return View
     */
    public function getDiscipline($id)
    {
        $discipline = Discipline::find($id);

        $discipline->issued_to_name = User::find($discipline['user_id'])->name;
        $discipline->issued_to_department_id = User::find($discipline['user_id'])->department_id;
        $discipline->issued_to_website_id = User::find($discipline['user_id'])->website_id;

        return $discipline;
    }

    /**
     * Edits specific discipline instance
     *
     * @return View
     */
    public function edit(Request $request)
    {
        $discipline = Discipline::find($request->route('id'));
        $this->editValidator($request->all())->validate();

        $discipline->issued_by = $request['issued_by'];
        $discipline->discipline_date = date("Y-m-d", strtotime($request['date']));
        $discipline->type = $request['type'];
        if($request['custom_expiry_date'] != null) {
            $discipline->custom_expiry_date = date("Y-m-d", strtotime($request['custom_expiry_date']));
        } else $discipline->custom_expiry_date = null;
        $discipline->details = $request['details'];
        $discipline->overturned = $request['overturned'];
        if($request['overturned_date'] != null) {
            $discipline->overturned_date = date("Y-m-d", strtotime($request['overturned_date']));
        } else $discipline->overturned_date = null;
        $discipline->overturned_by = $request['overturned_by'];
        $discipline->disputed = $request['disputed'];
        if($request['disputed_date'] != null) {
            $discipline->disputed_date = date("Y-m-d", strtotime($request['disputed_date']));
        } else $discipline->disputed_date = null;
        $discipline->save();

        return;
    }

    /**
     * Gets a specific users' discipline
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function disciplineData($id)
    {
        $constants = \Config::get('constants');
        $query = Discipline::query()
        ->leftJoin('users as t1', 'discipline.user_id', '=', 't1.id')
        ->leftJoin('users as t2', 'discipline.issued_by', '=', 't2.id')
        ->leftJoin('users as t3', 'discipline.overturned_by', '=', 't3.id')
        ->select([
            'discipline.id as discipline_id',
            'discipline.user_id as issued_to',
            'discipline.issued_by as issued_by',
            'discipline.discipline_date as discipline_date',
            'discipline.type as discipline_type',
            'discipline.details as discipline_details',
            'discipline.overturned as discipline_overturned',
            'discipline.overturned_by as discipline_overturned_by',
            'discipline.overturned_date as discipline_overturned_date',
            'discipline.disputed as discipline_disputed',
            'discipline.disputed_date as discipline_disputed_date',
            't1.name as issued_to_name',
            't1.department_id as issued_to_department_id',
            't1.website_id as issued_to_website_id',
            't2.name as issued_by_name',
            't2.department_id as issued_by_department_id',
            't2.website_id as issued_by_website_id',
            't3.name as overturned_by_name',
            't3.department_id as overturned_by_department_id',
            't3.website_id as overturned_by_website_id',
        ])->where('discipline.user_id', '=', $id);

        return datatables($query)
        ->editColumn('issued_to', function($row){
                    if ( $row->issued_to_department_id == null ) {
                        return $row->issued_to_name;
                    }
                    else return $row->issued_to_name.' '.$row->issued_to_department_id;})
        ->editColumn('issued_by', function($row){
                    if ( $row->issued_by_department_id == null ) {
                        return $row->issued_by_name;
                    }
                    else return $row->issued_by_name.' '.$row->issued_by_department_id;})
        ->editColumn('discipline_overturned_by', function($row){
                    if ( $row->overturned_by_department_id == null ) {
                        return $row->overturned_by_name;
                    }
                    else return $row->overturned_by_name.' '.$row->overturned_by_department_id;})
        ->editColumn('discipline_type', function($row){
                    $constants = \Config::get('constants');
                    return $constants['disciplinary_actions'][$row->discipline_type];})
        ->addColumn('discipline_status', function($row){
                    $status = AntelopeCalculate::discipline_status($row->discipline_id);
                    $constants = \Config::get('constants');
                    return $constants['disciplinary_action_status'][$status];})
        ->filterColumn('discipline_id', function($query, $keyword) {
                    $constants = \Config::get('constants');
                    $prefix = $constants['global_id']['disciplinary_action'];
                    if (substr($keyword, 0, strlen($prefix)) == $prefix) {
                        $keyword = substr($keyword, strlen($prefix));
                    }
                    $sql = "REPLACE(discipline.id, '".$constants['global_id']['disciplinary_action']."', '')  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                    })
        ->filterColumn('issued_to', function($query, $keyword) {
                    if (preg_match('/[0-9]/', $keyword)) {
                        $sql = "CONCAT(t1.name,' ',t1.department_id)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    } else {
                        $sql = "CONCAT(t1.name)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    }
                    })
        ->filterColumn('issued_by', function($query, $keyword) {
                    if (preg_match('/[0-9]/', $keyword)) {
                        $sql = "CONCAT(t2.name,' ',t2.department_id)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    } else {
                        $sql = "CONCAT(t2.name)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    }
                    })
        ->rawColumns(['discipline.details'])
        ->toJson();
    }
}