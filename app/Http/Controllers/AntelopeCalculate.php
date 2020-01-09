<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Activity;
use Illuminate\Support\Facades\Auth;

class AntelopeCalculate extends Controller
{
	 /**
     * Get the last patrol made by user, 
     *
     * @return timestamp
     */
    public static function get_last_timestamp($id) {

		if(null !== Activity::where('user_id', '=', $id)) {
			$timestamp = Activity::orderBy('patrol_end_date', 'DESC')->where('user_id', '=', $id)->first();
			$timestamp = $timestamp['patrol_end_date'];
		}

		if ($timestamp == null) {
			$timestamp = 'N/A';
		}

		return $timestamp;
    }

	 /**
     * Get the last patrol made by user, 
     *
     * @return human readable time
     */
    public static function get_last_seen($id) {

		$timestamp = self::get_last_timestamp($id);

		if ($timestamp == 'N/A') {
			return 'Never';
		}
		return Carbon::createFromTimeStamp(strtotime($timestamp))->diffForHumans();
    }
}
