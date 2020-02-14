<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AntelopePublic extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Activity Controller
    |--------------------------------------------------------------------------
    |
    */

    public $constants;

    /**
     * Executes before running the main controllers
     *
     * @author Oliver G.
     * @param
     * @return void
     * @version 1.0.0
     */
    public function __construct()
    {
        $this->constants = \Config::get('constants');
    }


    /**
     * Backend controller for the public_roster module
     *
     * @author Oliver G.
     * @return View
     * @category AntelopePublic
     * @version 1.0.0
     */
    protected function publicRoster_view()
    {
        return view('public.public_roster')->with('constants', $this->constants);
    }

}
