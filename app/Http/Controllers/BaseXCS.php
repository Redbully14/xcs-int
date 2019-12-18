<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BaseXCS extends Controller
{
    /**
     * Show the welcome view for XCS
     *
     * @return View
     */
    public function xcsInfo()
    {   
    	$constants = \Config::get('constants');
        return view('welcome')->with('constants', $constants);
    }
}