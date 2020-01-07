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

    /**
     * Converts seconds into duration
     *
     * @return H:i:s
     */
    public static function convertToDuration($duration) {
        $H = floor($duration / 3600);
        $i = ($duration / 60) % 60;
        $s = $duration % 60;
        return sprintf("%02d:%02d:%02d", $H, $i, $s);
    }
}