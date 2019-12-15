<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntelopeController extends Controller
{
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
     * Connects a person to the main dashboard
     *
     * @return View
     */
    public function dashboard()
    {
    	$constants = \Config::get('constants.global');

    	return view('dashboard')->with('constants', $constants);
    }

    /**
     * Gives a person access to the member administration
     *
     * @return View
     */
    public function memberAdmin()
    {
        $constants = \Config::get('constants.global');
        $users = DB::table('users')->get();
        $access = \Config::get('constants.access');
        $ranks = \Config::get('constants.rank');
        $status_colors = \Config::get('constants.antelope_status_color');
        $status_text = \Config::get('constants.antelope_status_text');

        // Removing superadmin access
        array_shift($access);

        return view('member_admin')
        ->with('constants', $constants)
        ->with('users', $users)
        ->with('access', $access)
        ->with('ranks', $ranks)
        ->with('status_colors', $status_colors)
        ->with('status_text', $status_text);
    }
}