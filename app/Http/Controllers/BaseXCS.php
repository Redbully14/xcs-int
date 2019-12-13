<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseXCS extends Controller
{
    /**
     * Show the welcome view for XCS
     *
     * @return View
     */
    public function xcsInfo()
    {   
        return view('welcome');
    }

    public function dashboard()
    {
    	$constants = \Config::get('constants.global');

    	return view('dashboard')->with('constants', $constants);
    }
}