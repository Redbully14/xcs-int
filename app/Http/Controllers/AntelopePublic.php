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
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['admin'])
        ->orderBy('department_id');

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
            'advanced_training'
        ])->whereIn('rank', $this->constants['rank_groups']['senior_staff'])
        ->orderBy('department_id');

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
        ->orderBy('department_id');

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
        ->orderBy('department_id');

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
