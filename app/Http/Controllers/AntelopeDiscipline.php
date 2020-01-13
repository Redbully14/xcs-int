<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Datatables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;

class AntelopeDiscipline extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Discipline Controller
    |--------------------------------------------------------------------------
    |
    */

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
     * Construct Discipline Page
     *
     * @return View
     */
    public function constructPage()
    {
        $constants = \Config::get('constants');

        return view('discipline_database')->with('constants', $constants);
    }
}
