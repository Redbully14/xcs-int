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
	    ->leftJoin('users as t3', 'discipline.issued_by', '=', 't3.id')
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
	        't1.name as t1_name',
	        't1.department_id as t1_department_id',
	        't1.website_id as t1_website_id',
	        't2.name as t2_name',
	        't2.department_id as t2_department_id',
	        't2.website_id as t2_website_id',
	        't3.name as t3_name',
	        't3.department_id as t3_department_id',
	        't3.website_id as t3_website_id',
	    ]);

	    return datatables($query)
	    ->editColumn('issued_to', function($row){
	                if ( $row->t1_department_id == null ) {
	                    return $row->t1_name;
	                }
	                else return $row->t1_name.' '.$row->t1_department_id;})
	    ->editColumn('issued_by', function($row){
	                if ( $row->t2_department_id == null ) {
	                    return $row->t2_name;
	                }
	                else return $row->t2_name.' '.$row->t2_department_id;})
	    ->editColumn('discipline_overturned_by', function($row){
	                if ( $row->t3_department_id == null ) {
	                    return $row->t3_name;
	                }
	                else return $row->t3_name.' '.$row->t3_department_id;})
		->filterColumn('discipline_id', function($query, $keyword) {
					$constants = \Config::get('constants');
					$prefix = $constants['global_id']['disciplinary_action'];
					if (substr($keyword, 0, strlen($prefix)) == $prefix) {
					    $keyword = substr($keyword, strlen($prefix));
					}
					$sql = "REPLACE(discipline.id, '".$constants['global_id']['disciplinary_action']."', '')  like ?";
	                $query->whereRaw($sql, ["%{$keyword}%"]);
	            })
	    ->toJson();
    }
}
