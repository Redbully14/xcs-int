<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Activity;
use App\Discipline;
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
            return '-';
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

     /**
     * Get the total amount of patrol hours in database (custom time entry)
     *
     * @return H:i:s
     */
    public static function get_ctime_patrol_hours($id, $time) {

        $constants = \Config::get('constants');
        $patrols = Activity::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total_duration = 0;

        if(is_string($time)) {
            $time = $constants['calculation'][$time];
        }

        foreach($patrols as $patrol) {
            if (strtotime($patrol->patrol_end_date)+$time > $today) {
                $start_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_start_date $patrol->start_time"));
                $end_date_time = date('Y-m-d H:i:s', strtotime("$patrol->patrol_end_date $patrol->end_time"));

                $start_date_time = strtotime($start_date_time);
                $end_date_time = strtotime($end_date_time);

                $duration = $end_date_time - $start_date_time;
                $total_duration = $total_duration + $duration;
            }
        }

        if ($total_duration == 0) {
            return '-';
        }

        return BaseXCS::convertToDuration($total_duration);
    }

     /**
     * Checks if a person meets requirements (month entry)
     *
     * @return string
     */
    public static function get_month_requirements($id, $calmonth) {

        $constants = \Config::get('constants');
        $check_month = date('m') - $calmonth;
        $check_year = date('Y');
        $patrols = self::get_month_patrol_logs($id, $calmonth);
        $hours = strtotime(self::get_month_patrol_hours($id, $calmonth));
        $member_month = date('m', strtotime(User::find($id)->created_at));
        $member_year = date('Y', strtotime(User::find($id)->created_at));

        if($check_month <= 0) {
            $check_year = $check_year - 1;
            $check_month = 12 + $check_month; // Because it's a negative int this gets negated anyways
        } else {
            $check_month = date('m');
        }

        if ($patrols >= $constants['calculation']['min_requirements_logs'] && $hours >= $constants['calculation']['min_requirements_hours']) {
            return 'met';
        }

        if (User::find($id)->requirements_exempt) {
            return 'exempt';
        }

        if($member_month == $check_month && $member_year == $check_year) {
            return 'new';
        }


        return 'not_met';
    }

     /**
     * Checks the total amount of disciplines issued to certain Website ID
     *
     * @param $id (int)
     * @return int
     */
    public static function get_total_disciplines($id) {

        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $total = 0;

        foreach($disciplines as $discipline) {
            $total++;
        }

        return $total;
    }

     /**
     * Checks the CUSTOM amount of disciplines issued to certain Website ID
     *
     * @param $id (int), $type (int)
     * @return int
     */
    public static function get_custom_disciplines($id, $type) {

        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $total = 0;

        foreach($disciplines as $discipline) {
            if($discipline->type == $type) {
                $total++;
            }
        }

        return $total;
    }

     /**
     * Checks the total amount of ACTIVE disciplines issued to certain Website ID
     *
     * @param $id (int)
     * @return int
     */
    public static function get_total_active_disciplines($id) {

        $constants = \Config::get('constants');
        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total = 0;

        foreach($disciplines as $discipline) {
            $discipline_date = strtotime($discipline->discipline_date);
            $discipline_type = $discipline->type;
            if($discipline_date+$constants['disciplinary_action_active'][$discipline_type] >= $today) {
                $total++;
            }
        }

        return $total;
    }

     /**
     * Checks the CUSTOM amount of ACTIVE disciplines issued to certain Website ID
     *
     * @param $id (int), $type (int)
     * @return int
     */
    public static function get_custom_active_disciplines($id, $type) {

        $constants = \Config::get('constants');
        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total = 0;

        foreach($disciplines as $discipline) {
            $discipline_date = strtotime($discipline->discipline_date);
            if($discipline->type == $type) {
                if($discipline_date+$constants['disciplinary_action_active'][$type] >= $today) {
                    $total++;
                }
            }
        }

        return $total;
    }

     /**
     * Get the patrol restriction status issued to certain Website ID
     *
     * @param $id (int), $type (int)
     * @return int
     */
    public static function chk_patrol_restriction($id) {

        $constants = \Config::get('constants');
        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total = 0;

        foreach($disciplines as $discipline) {
            $discipline_date = strtotime($discipline->discipline_date);
            if($discipline->type == 1) {
                if($discipline_date+$constants['calculation']['patrol_restriction_90'] >= $today) {
                    $total++;
                }
            } else if ($discipline->type == 2) {
                if($discipline_date+$constants['calculation']['patrol_restriction_93'] >= $today) {
                    $total++;
                }
            }
        }

        if($total > 0) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

     /**
     * Get the patrol restriction status issued to certain Website ID
     *
     * @param $id (int)
     * @return str
     */
    public static function discipline_status($id) {

        $constants = \Config::get('constants');
        $discipline = Discipline::find($id);
        $today = strtotime(Carbon::now()->toDateString());
        $discipline_date = strtotime($discipline->discipline_date);

        if($discipline->overturned) {
            return 'overturned';
        }

        if($discipline->disputed) {
            if($discipline_date+$constants['disciplinary_action_active'][$discipline->type] < $today) {
                return 'expired';
            }
            return 'disputed_active';
        }

        if($discipline_date+$constants['disciplinary_action_active'][$discipline->type] < $today) {
            return 'expired';
        }

        return 'active';
    }
}
