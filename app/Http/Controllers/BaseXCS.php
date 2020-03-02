<?php
/*
|------------------------------------------------------------------------------------
|                           BASEXCS MAIN WEBSITE INFO
|------------------------------------------------------------------------------------
|
| FRAMEWORK NAME: XCS-int
| FRAMEWORK AUTHOR: Oliver G.
| FRAMEWORK CONTACT EMAIL: Redbully14urh@gmail.com
|------------------------------------------------------------------------------------
|                           BASEXCS APPLICATION INFO
|------------------------------------------------------------------------------------
| 
| APPLICATION NAME: AntelopePHP
| APPLICATION AUTHOR: Oliver G.
| APPLICATION CONTACT EMAIL: Redbully14urh@gmail.com
| APPLICATION WEBSITE: /
| APPLICATION GITHUB: https://github.com/Redbully14/xcs-int
| APPLICATION SUBSIDIARIES: + AntelopePHP Base
|                           + 
|                           + 
|                           + 
| 
| CREATED FOR: Department of Justice Roleplay Community (www.dojrp.com)
| 
|-----------------------------------------------------------------------------------
|                           BASEXCS LICENSE INFO
|-----------------------------------------------------------------------------------
| 
|    MIT License
|
|    Copyright (c) 2020 XCS-int
|
|    Permission is hereby granted, free of charge, to any person obtaining a copy
|    of this software and associated documentation files (the "Software"), to deal
|    in the Software without restriction, including without limitation the rights
|    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
|    copies of the Software, and to permit persons to whom the Software is
|    furnished to do so, subject to the following conditions:
|
|    The above copyright notice and this permission notice shall be included in all
|    copies or substantial portions of the Software.
|
|    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
|    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
|    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
|    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
|    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
|    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
|    SOFTWARE.
|
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class BaseXCS extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BaseXCS Main Website Controller
    |--------------------------------------------------------------------------
    |
    */

    static $constants;

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
        self::$constants = \Config::get('constants');
    }

    /**
     * Converts seconds into a H:i:s format duration
     *
     * @author Oliver G.
     * @param var $duration
     * @return string
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function convertToDuration($duration) {
        $H = floor($duration / 3600);
        $i = ($duration / 60) % 60;
        $s = $duration % 60;
        return sprintf("%02d:%02d:%02d", $H, $i, $s);
    }

    /**
     * Converts seconds into days
     *
     * @author Oliver G.
     * @param var $duration
     * @return string
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function convertToDays($duration) {
        $d = floor($duration / 86400);
        return $d;
    }

    /**
     * Converts duration to seconds
     *
     * @author Oliver G.
     * @param var $duration
     * @return string
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function durationToSeconds($duration) {
        sscanf($duration, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
        return $time_seconds;
    }

    /**
     * Converts a timezone into UTC
     *
     * @author Oliver G.
     * @param var $user
     * @param var $timestamp
     * @return var $date
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function convertTimezone($user, $timestamp) {
        $user_timezone = User::find($user)->timezone;
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, $user_timezone);
        return $date->setTimezone('UTC');
    }

    /**
     * Attempts to convert an avatar by checking if it exists in the system
     *
     * @author Oliver G.
     * @param var $avatar
     * @param var $type
     * @return var $avatar
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function convertAvatar($avatar, $type) {

        if($type == 1) {
            try {
                $avatar = self::$constants['avatars'][$avatar];
            } catch(\Exception $e) {
                $avatar = self::$constants['avatars']['antelope'];
            }
        } else if ($type == 2) {
            try {
                $avatar = self::$constants['avatar_filename'][$avatar];
            } catch(\Exception $e) {
                $avatar = self::$constants['avatar_filename']['antelope'];
            }
        }
        return $avatar;
    }

    /**
     * Gets a certain user and returns App\User
     *
     * @author Oliver G.
     * @param var $id
     * @return var $user
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function getUser($id) {
        $user = User::find($id);

        return $user;
    }

    /**
     * Gets all the member and returs a searchable url link in array
     *
     * @author Oliver G.
     * @return array $members_array
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function getAllMembersSearchable() {
        $users = User::where([
            ['rank', '!=', 'ia'],
            ['rank', '!=', 'other_guest'],
            ['rank', '!=', 'other_admin'],
        ])
        ->get();
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
     * Gets all the members and returrns them in a array
     *
     * @author Oliver G.
     * @return array $member_array
     * @category BaseXCS
     * @version 1.0.0
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

    /**
     * Generates a random user login number
     *
     * @author Oliver G.
     * @return int
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function generateUsername() {
        $username = mt_rand(10000000, 99999999);

        if(User::where('username', $username)->exists()) {
            return self::generateUsername();
        }

        return $username;
    }

    /**
     * Generates a random user password
     *
     * @author Oliver G.
     * @return string
     * @category BaseXCS
     * @version 1.0.0
     */
    public static function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}