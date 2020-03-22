<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\User;
use App\Http\Controllers\AntelopeCalculate;

class AntelopePublic extends Controller
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
     * @version 1.0.0
     */
    public function __construct()
    {
        $this->constants = \Config::get('constants');
    }


    /**
     * Backend controller for the public_roster module
     *
     * @author Oliver G.
     * @return View
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_view()
    {
        return view('public.public_roster')->with('constants', $this->constants);
    }

    /**
     * Constructs the 'Department Administration' part of the Public Roster
     * The following SQL STATEMENT is used to strip the Civ-/CivM- away from Civilian Numbers (ensure to use it in a query):
     * CAST(REPLACE(REPLACE(department_id,"Civ-",""), "CivM-", "") as SIGNED)
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_admins()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training',
        ])
        ->whereIn('rank', $this->constants['rank_groups']['admin'])
        ->orderByRaw("CAST(REPLACE(department_id,'5E-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Department Senior Staff' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_seniorstaff()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training',
        ])->whereIn('rank', $this->constants['rank_groups']['senior_staff'])
        ->orderByRaw("CAST(REPLACE(department_id,'5S-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Department Staff' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_staff()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['staff'])
        ->orderByRaw("CAST(REPLACE(department_id,'5S-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Department Staff in Training' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_staffintraining()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['sit'])
        ->orderByRaw("CAST(REPLACE(department_id,'5D-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Senior Members' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_seniormember()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['senior_member'])
        ->orderByRaw("CAST(REPLACE(department_id,'5D-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Members' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_member()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['member'])
        ->orderByRaw("CAST(REPLACE(department_id,'5D-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Probationary Members' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_probationarymember()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['probationary_member'])
        ->orderByRaw("CAST(REPLACE(department_id,'5D-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Reserve' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_reserve()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['reserve'])
        ->orderByRaw("CAST(REPLACE(department_id,'5R-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

    /**
     * Constructs the 'Media' part of the Public Roster
     *
     * @author Oliver G.
     * @return DataTable
     * @category AntelopePublic
     * @version 1.0.0
     */
    public function publicRoster_datatables_media()
    {
        $query = User::query()
        ->select([
            'id',
            'name',
            'department_id',
            'rank',
            'website_id',
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['media'])
        ->orderByRaw("CAST(REPLACE(department_id,'5R-','') as SIGNED) asc");

        return datatables($query)
        ->editColumn('rank', function($row){
                    return $this->constants['rank'][$row->rank];})
        ->addColumn('status', function($row){
                    $rawstatus = AntelopeCalculate::get_department_status($row->id);
                    $status = $this->constants['department_status'][$rawstatus];
                    return '<span class="text-'.$this->constants['department_status_colors'][$rawstatus].'">'.$status.'</span>';})
        ->addColumn('monthly_hours', function($row){
                    $hours = AntelopeCalculate::get_month_patrol_hours($row->id, 0);
                    return $hours;})
        ->addColumn('monthly_logs', function($row){
                    $logs = AntelopeCalculate::get_month_patrol_logs($row->id, 0);
                    if ($logs == "N/A") {
                        $logs = '-';
                    }
                    return $logs;})
        ->editColumn('advanced_training', function($row){
                    return $row->advanced_training ? '✔️' : '❌';})
        ->addColumn('requirements', function($row){
                    $rawstatus = AntelopeCalculate::get_month_requirements($row->id, 0);
                    $status = $this->constants['requirements'][$rawstatus];
                    return '<span class="text-'.$this->constants['requirements_colors'][$rawstatus].'">'.$status.'</span>';})
        ->rawColumns(['status', 'requirements'])
        ->toJson();
    }

}
