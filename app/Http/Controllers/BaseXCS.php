<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseXCS extends Controller
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
     * Show the welcome view for XCS
     *
     * @return View
     */
    public function xcsInfo()
    {   
        return view('welcome');
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
}