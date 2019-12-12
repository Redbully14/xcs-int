<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BaseXCS extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show()
    {
        return view('welcome');
    }
}