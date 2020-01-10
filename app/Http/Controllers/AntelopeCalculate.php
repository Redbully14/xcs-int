<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Activity;
use App\User;
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
			$date = Activity::orderBy('patrol_end_date', 'DESC')->where('user_id', '=', $id)->first();
			$date = $date['patrol_end_date'];

            $time = Activity::orderBy('end_time', 'DESC')->where('user_id', '=', $id)->first();
            $time = $time['end_time'];

            $timestamp = $date.' '.$time;
		}

		if ($date == null) {
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

	 /**
     * Get the user's department status.
     *
     * @return string
     */
    public static function get_department_status($id) {

    	$constants = \Config::get('constants');

    	$last_timestamp = self::get_last_timestamp($id);

    	$today = strtotime(Carbon::now()->toDateString());

    	if($last_timestamp == 'N/A') {
    		if(!strtotime(User::find($id)->created_at)+$constants['calculation']['account_is_new'] < $today ) {
    			return 'new';
    		}
    	}

    	$last_timestamp = strtotime($last_timestamp);

    	if($last_timestamp+$constants['calculation']['time_to_inactive'] < $today ) {
    		return 'inactive';
    	}

    	return 'active';
    }

     /**
     * Get the total amount of patrol logs in database
     *
     * @return int
     */
    public static function get_total_patrol_logs($id) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $patrols = $patrols->count();

        if ($patrols == 0) {
            return 'N/A';
        }

        return $patrols;
    }

     /**
     * Get the total amount of patrol hours in database
     *
     * @return H:i:s
     */
    public static function get_total_patrol_hours($id) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $total_duration = 0;

        foreach($patrols as $patrol) {
            $start_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_start_date $patrol->start_time"));
            $end_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_end_date $patrol->end_time"));

            $start_date_time = strtotime($start_date_time);
            $end_date_time = strtotime($end_date_time);

            $duration = $end_date_time - $start_date_time;
            $total_duration = $total_duration + $duration;
        }

        if ($total_duration == 0) {
            return '-';
        }

        return BaseXCS::convertToDuration($total_duration);
    }

     /**
     * Get the total amount of patrol logs in database (in a month)
     *
     * @return int
     */
    public static function get_month_patrol_logs($id, $calmonth) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $count = 0;

        $check_month = date('m') - $calmonth;
        $check_year = date('Y');

        if($check_month <= 0) {
            $check_year = $check_year - 1;
            $check_month = 12 + $check_month; // Because it's a negative int this gets negated anyways
        } else {
            $check_month = date('m');
        }

        foreach($patrols as $patrol) {
            $patrol_month = date('m', strtotime($patrol->patrol_end_date));
            $patrol_year = date('Y', strtotime($patrol->patrol_end_date));
            if($patrol_month == $check_month && $patrol_year == $check_year) {
                $count++;
            }
        }

        if ($count == 0) {
            return 'N/A';
        }

        return $count;
    }

     /**
     * Get the total amount of patrol hours in database (in a month)
     *
     * @return H:i:s
     */
    public static function get_month_patrol_hours($id, $calmonth) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $total_duration = 0;

        $check_month = date('m') - $calmonth;
        $check_year = date('Y');

        if($check_month <= 0) {
            $check_year = $check_year - 1;
            $check_month = 12 + $check_month; // Because it's a negative int this gets negated anyways
        } else {
            $check_month = date('m');
        }

        foreach($patrols as $patrol) {
            $patrol_month = date('m', strtotime($patrol->patrol_end_date));
            $patrol_year = date('Y', strtotime($patrol->patrol_end_date));
            if($patrol_month == $check_month && $patrol_year == $check_year) {
                $start_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_start_date $patrol->start_time"));
                $end_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_end_date $patrol->end_time"));

                $start_date_time = strtotime($start_date_time);
                $end_date_time = strtotime($end_date_time);

                $duration = $end_date_time - $start_date_time;
                $total_duration = $total_duration + $duration;
            }
        }

        if ($total_duration == 0) {
            return 'N/A';
        }

        return BaseXCS::convertToDuration($total_duration);
    }

     /**
     * Get the total amount of patrol logs in database (custom time entry)
     *
     * @return int
     */
    public static function get_ctime_patrol_logs($id, $time) {

        $constants = \Config::get('constants');
        $patrols = Activity::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $count = 0;

        if(is_string($time)) {
            $time = $constants['calculation'][$time];
        }

        foreach($patrols as $patrol) {
            if (strtotime($patrol->patrol_end_date)+$time > $today) {
                $count++;
            }
        }

        if ($count == 0) {
            return 'N/A';
        }

        return $count;
    }
}
