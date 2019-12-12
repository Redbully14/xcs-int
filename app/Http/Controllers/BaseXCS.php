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
    public function show()
    {
        return view('welcome');
    }
}