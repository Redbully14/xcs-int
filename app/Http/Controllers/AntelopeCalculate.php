<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\BaseXCS;
use App\Activity;
use App\Discipline;
use App\Absence;
use App\User;
use Illuminate\Support\Facades\Auth;

class AntelopeCalculate extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Activity Controller
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Gets the last patrol timestamp of the last activity log within the database
     *
     * @author Oliver G.
     * @param var $id
     * @return var $timestamp
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_last_timestamp($id) {

        $date = Activity::orderBy('patrol_end_date', 'DESC')->where('user_id', '=', $id)->first();
        $time = Activity::orderBy('end_time', 'DESC')->where('user_id', '=', $id)->first();

        if (!is_null($date)) {
            $date = $date['patrol_end_date'];
            $time = $time['end_time'];
            $timestamp = $date . ' ' . $time;
        } else {
            $timestamp = 'N/A';
        }

		return $timestamp;
    }

    /**
     * Generates a human-readable value of the last timestamp value
     *
     * @author Oliver G.
     * @param var $id
     * @return Carbon
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_last_seen($id) {

		$timestamp = self::get_last_timestamp($id);

		if ($timestamp == 'N/A') {
			return 'Never';
		}
		return Carbon::createFromTimeStamp(strtotime($timestamp))->diffForHumans();
    }

    /**
     * Gets the member's department status depending on their patrol log and when their account was created
     *
     * @author Oliver G.
     * @param var $id
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_department_status($id) {

        $constants = \Config::get('constants');

    	$last_timestamp = self::get_last_timestamp($id);
    	$today = strtotime(Carbon::now()->toDateString());

        if(self::absence_status($id) == 'Active') {
            return 'absent';
        }

    	if($last_timestamp == 'N/A') {
    		if(strtotime(User::find($id)->created_at)+$constants['calculation']['account_is_new'] > $today ) {
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
     * Gets a total amount of activity logs connected to a user_id
     *
     * @author Oliver G.
     * @param var $id
     * @return var $patrols
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_total_patrol_logs($id) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $patrols = $patrols->count();

        if(User::find($id)->requirements_exempt) {
            return '-';
        }

        if ($patrols == 0) {
            return 'N/A';
        }

        return $patrols;
    }

    /**
     * Gets a total amount of activity hours connected to a user_id
     *
     * @author Oliver G.
     * @param var $id
     * @return var $total_duration
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_total_patrol_hours($id) {

        $patrols = Activity::where('user_id', '=', $id)->get();
        $total_duration = 0;

        if(User::find($id)->requirements_exempt) {
            return '-';
        }

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
     * Gets a certain amount of activity LOGS submitted in a selected month connected to a user_id
     * This calculation is made by deducting $calmonth from the current month
     *
     * @author Oliver G.
     * @param var $id
     * @param var $calmonth
     * @return var $count
     * @category AntelopeCalculate
     * @version 1.0.0
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

        if(User::find($id)->requirements_exempt) {
            return '-';
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
     * Gets a certain amount of activity HOURS submitted in a selected month connected to a user_id
     * This calculation is made by deducting $calmonth from the current month
     *
     * @author Oliver G.
     * @param var $id
     * @param var $calmonth
     * @return var $total_duration
     * @category AntelopeCalculate
     * @version 1.0.0
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

        if(User::find($id)->requirements_exempt) {
            return '-';
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
     * Gets a certain amount of activity LOGS submitted in a selected timeframe connected to a user_id
     * This calculation is made by checking how many days ago via variable $time you wish to search
     * for patrol logs, make sure you input the $time value within seconds 
     * (example: if $time = 30 days ago then it fetches all patrol logs within 30 days)
     *
     * @author Oliver G.
     * @param var $id
     * @param var $time
     * @return var $count
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_ctime_patrol_logs($id, $time) {

        $constants = \Config::get('constants');
        $patrols = Activity::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $count = 0;
        $constants = \Config::get('constants');
        if(is_string($time)) {
            $time = $constants['calculation'][$time];
        }

        if(User::find($id)->requirements_exempt) {
            return '-';
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
     * Gets a certain amount of activity HOURS submitted in a selected timeframe connected to a user_id
     * This calculation is made by checking how many days ago via variable $time you wish to search
     * for patrol logs, make sure you input the $time value within seconds
     * (example: if $time = 30 days ago then it fetches all patrol logs within 30 days)
     *
     * @author Oliver G.
     * @param var $id
     * @param var $time
     * @return var $total_duration
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_ctime_patrol_hours($id, $time) {

        $constants = \Config::get('constants');
        $patrols = Activity::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total_duration = 0;
        $constants = \Config::get('constants');
        if(is_string($time)) {
            $time = $constants['calculation'][$time];
        }

        if(User::find($id)->requirements_exempt) {
            return '-';
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
     * Checks if a person has met their monthly requirements for a selected month
     * This calculation is made by deducting $calmonth from the current month
     *
     * @author Oliver G.
     * @param var $id
     * @param var $calmonth
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_month_requirements($id, $calmonth) {

        $constants = \Config::get('constants');
        $check_month = date('m') - $calmonth;
        $check_year = date('Y');
        $patrols = self::get_month_patrol_logs($id, $calmonth);
        $hours = strtotime(self::get_month_patrol_hours($id, $calmonth));
        $member_month = date('m', strtotime(User::find($id)->created_at));
        $member_year = date('Y', strtotime(User::find($id)->created_at));
        $constants = \Config::get('constants');

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
            if(Auth::user() && Auth::user()->requirements_exempt) {
                return 'exempt';
            }
            return 'met';
        }

        if($member_month == $check_month && $member_year == $check_year) {
            return 'new';
        }


        return 'not_met';
    }

    /**
     * Gets a total amount of discipline logs connected to a user_id
     *
     * @author Oliver G.
     * @param var $id
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
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
     * Gets total amount of discipline logs connected to a user_id that also match the type
     *
     * @author Oliver G.
     * @param var $id
     * @param var $type
     * @return var $total
     * @category AntelopeCalculate
     * @version 1.0.0
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
     * Gets total amount of discipline logs connected to a user_id that are currently active
     *
     * @author Oliver G.
     * @param var $id
     * @return var $total
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_total_active_disciplines($id) {

        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $total = 0;

        foreach($disciplines as $discipline) {
            $discipline_status = self::discipline_status($discipline->id);
            if($discipline_status == 'active' or $discipline_status == 'disputed_active') {
                $total++;
            }
        }

        return $total;
    }

    /**
     * Gets total amount of discipline logs connected to a user_id that also match the type
     * AND are currently active
     *
     * @author Oliver G.
     * @param var $id
     * @param var $type
     * @return var $total
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function get_custom_active_disciplines($id, $type) {

        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $total = 0;

        foreach($disciplines as $discipline) {
            $discipline_status = self::discipline_status($discipline->id);
            if($discipline->type == $type) {
                if($discipline_status == 'active' or $discipline_status == 'disputed_active') {
                    $total++;
                }
            }
        }

        return $total;
    }

    /**
     * Checks if a user_id has an active patrol restriction
     *
     * @author Oliver G.
     * @param var $id
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function chk_patrol_restriction($id) {

        $constants = \Config::get('constants');
        $disciplines = Discipline::where('user_id', '=', $id)->get();
        $today = strtotime(Carbon::now()->toDateString());
        $total = 0;
        $constants = \Config::get('constants');
        foreach($disciplines as $discipline) {
            $discipline_date = strtotime($discipline->discipline_date);
            $discipline_status = self::discipline_status($discipline->id);
            if($discipline->type == 1) {
                if($discipline_date+$constants['calculation']['patrol_restriction_90'] >= $today && $discipline_status == 'active' or $discipline_status == 'disputed_active') {
                    return 'Yes';
                }
            } else if ($discipline->type == 2) {
                if($discipline_date+$constants['calculation']['patrol_restriction_93'] >= $today && $discipline_status == 'active' or $discipline_status == 'disputed_active') {
                    return 'Yes';
                }
            }
        }
        return 'No';
    }

    /**
     * Calulcates and fetches the discipline status by checking the discipline_id
     *
     * @author Oliver G.
     * @param var $id
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function discipline_status($id) {

        $constants = \Config::get('constants');
        $discipline = Discipline::find($id);
        $today = strtotime(Carbon::now()->toDateString());
        $discipline_date = strtotime($discipline->discipline_date);
        $custom_expiry_date = strtotime($discipline->custom_expiry_date);
        $custom_expiry_nulled = $discipline->custom_expiry_date;
        $constants = \Config::get('constants');
        if($discipline->overturned) {
            return 'overturned';
        }

        if($discipline->disputed) {
            if($custom_expiry_nulled == null) {
                if($discipline_date+$constants['disciplinary_action_active'][$discipline->type] <= $today) {
                    return 'expired';
                }
            }

            if ($custom_expiry_nulled != null && $custom_expiry_date <= $today) {
                return 'expired';
            }
            return 'disputed_active';
        }

        if($custom_expiry_nulled == null) {
            if($discipline_date+$constants['disciplinary_action_active'][$discipline->type] <= $today) {
                return 'expired';
            }
        }

        if ($custom_expiry_nulled != null && $custom_expiry_date <= $today) {
            return 'expired';
        }

        return 'active';
    }

    /**
     * Calulcates and fetches the absence status by checking the user_id
     *
     * @author Oliver G.
     * @param var $id
     * @return string
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function absence_status($id) {

        $constants = \Config::get('constants');
        $absence = Absence::where('user_id', '=', $id);
        $today = strtotime(Carbon::now()->toDateString());
        $constants = \Config::get('constants');
        if(is_null($absence->latest('end_date')->first())) {
            return '-';
        }

        $absence = $absence->latest('end_date')->first();
        $start_date = strtotime($absence->start_date);
        $end_date = strtotime($absence->end_date);

        if($absence->status == 1) {
            if($start_date <= $today) {
                if($today <= $end_date) {
                    return 'Active';
                } else return 'Overdue';
            } else return 'Upcoming - '.date('Y-m-d', $start_date);
        } else return $constants['absence_status'][$absence->status];
    }

    /**
     * Calulcates and fetches the amount of patrol logs and hours needed to meet requirements
     *
     * @author Oliver G.
     * @param var $id
     * @return var $data
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function amount_to_requirements($id) {
        
        $constants = \Config::get('constants');
        $data = [
            'logs' => 0,
            'hours' => 0,
            'hours_met' => false,
            'logs_met' => false
        ];

        if(self::get_month_requirements($id, 0) == 'met' or self::get_month_requirements($id, 0) == 'exempt') {
            $data['hours_met'] = true;
            $data['logs_met'] = true;
            return $data;
        }

        $caldata = [
            'logs' => self::get_month_patrol_logs($id, 0),
            'hours' => self::get_month_patrol_hours($id, 0),
        ];

        if(BaseXCS::durationToSeconds($caldata['hours']) >= $constants['calculation']['min_requirements_hours']) {
            $data['hours_met'] = true;
        }

        if($caldata['logs'] >= $constants['calculation']['min_requirements_logs']) {
            $data['logs_met'] = true;
        }

        // Getting rid of the N/A and - values here if no patrol logs
        if ($caldata['logs'] == 'N/A') {
            $caldata['logs'] = 0;
        }

        if ($caldata['hours'] == '-') {
            $caldata['hours'] = 0;
        }

        $data['logs'] = $constants['calculation']['min_requirements_logs'] - $caldata['logs'];
        $data['hours'] = $constants['calculation']['min_requirements_hours'] - BaseXCS::durationToSeconds($caldata['hours']);
        $data['hours'] = (int)ceil($data['hours'] / 3600);
        

        if($data['logs'] < 0) {
            $data['logs'] = 0;
        }

        if($data['hours'] < 0) {
            $data['hours'] = 0;
        }

        return $data;
    }

    /**
     * Calulcates and fetches the absences with the in_queue status
     *
     * @author Oliver G.
     * @param var $id
     * @return int $total
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function absences_needing_approval() {

        $absences = Absence::where('status', '=', 0)->get();
        $total = 0;

        foreach($absences as $absence) {
            $total++;
        }

        return $total;
    }


    /**
     * Calculates and fetches the amount of patrol logs that are flagged and are not resolved
     *
     * @author Oliver G.
     * @param var $id
     * @return int $total
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function activity_flagged() {

        $activity = Activity::where('flag', '!=', null)->get();
        $total = 0;

        foreach($activity as $log) {
            $log = json_decode($log['flag']);
            $log = $log[0];
            if(($log[0] or $log[1]) and ($log[2] == false)) {
                $total++;
            }
        }

        return $total;
    }

    /**
     * Calculates and fetches the amount of absences that are flagged as overdue
     *
     * @author Oliver G.
     * @return int $total
     * @category AntelopeCalculate
     * @version 1.0.0
     */
    public static function overdue_absences() {

        $absences = Absence::where('status', '=', 1)->get();
        $total = 0;
        $today = strtotime(Carbon::now()->toDateString());

        foreach($absences as $absence) {
            $end_date = strtotime($absence->end_date);
            if ($today >= $end_date) {
                $total++;
            }
        }

        return $total;
    }
}
