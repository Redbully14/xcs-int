<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}