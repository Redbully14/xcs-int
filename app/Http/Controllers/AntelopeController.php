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

        return view('member_admin')->with('constants', $constants)->with('users', $users);
    }
}