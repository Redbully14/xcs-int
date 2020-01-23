<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

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

    /**
     * Converts an input from local time into system time
     *
     * @return void
     */
    public static function convertTimezone($user, $timestamp) {
        $user_timezone = User::find($user)->timezone;
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, $user_timezone);
        return $date->setTimezone('UTC');
    }

    /**
     * Attempt to convert an avatar
     *
     * @param $type = either 1 (name) or 2 (file)
     * @return string
     */
    public static function convertAvatar($avatar, $type) {
        $constants = \Config::get('constants');

        if($type == 1) {
            try {
                $avatar = $constants['avatars'][$avatar];
            } catch(\Exception $e) {
                $avatar = $constants['avatars']['antelope'];
            }
        } else if ($type == 2) {
            try {
                $avatar = $constants['avatar_filename'][$avatar];
            } catch(\Exception $e) {
                $avatar = $constants['avatar_filename']['antelope'];
            }
        }
        return $avatar;
    }

    /**
     * Get all members
     *
     * @return searchable string (000 - User N. Civ-0)
     */
    public static function getAllMembersSearchable() {
        $users = User::all();
        $members_array = array();

        foreach ($users as $user) {
            $name = $user->name;
            $department_id = $user->department_id;
            $website_id = $user->website_id;

            if ($department_id == null) {
                $member = $website_id.' - '.$name;
            } else {
                $member = $website_id.' - '.$name.' '.$department_id;
            }

            $members_array[url("/profile/{$user->id}")] = $member;
        }

        return $members_array;
    }

    /**
     * Get all members
     *
     * @return int
     */
    public static function getAllMembers() {
        $users = User::all();
        $members_array = array();

        foreach ($users as $user) {
            $name = $user->name;
            $department_id = $user->department_id;
            $website_id = $user->website_id;
            $id = $user->id;

            if ($department_id == null) {
                $member = $website_id.' - '.$name;
            } else {
                $member = $website_id.' - '.$name.' '.$department_id;
            }

            $members_array[$id] = $member;
        }

        return $members_array;
    }
}