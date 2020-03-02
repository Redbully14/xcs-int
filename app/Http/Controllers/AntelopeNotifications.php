<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AntelopeCalculate;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AntelopeNotifications extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Antelope Notifications Controller
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
     * @access Auth
     * @version 1.0.0
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->constants = \Config::get('constants');
    }

    /**
     * Gets the total number of notifications
     *
     * @author Oliver G.
     * @return int
     * @category AntelopeNotifications
     * @version 1.0.0
     */
    public static function notificationCount()
    {
    	$user = auth()->user();
    	$notification_count = $user->unreadNotifications;
    	if($notification_count == null) {
    		$notification_count = 0;
    	} else $notification_count = count($notification_count);

        return $notification_count;
    }

    /**
     * Gets all unread notifications
     *
     * @author Oliver G.
     * @return int
     * @category AntelopeNotifications
     * @version 1.0.0
     */
    public static function unreadNotifications()
    {
    	$user = auth()->user();
    	return $user->unreadNotifications->skip(0)->take(5);
    }

    /**
     * Clears all notifications
     *
     * @author Oliver G.
     * @return void
     * @category AntelopeNotifications
     * @version 1.0.0
     */
    public function clearAllNotifications()
    {
    	$user = auth()->user();
    	$user->unreadNotifications->markAsRead();
    }

    /**
     * Clears all notifications in the notifications center
     *
     * @author Oliver G.
     * @return void
     * @category AntelopeNotifications
     * @version 1.0.0
     */
    public function clearAllNotificationsinCenter()
    {
    	$user = auth()->user();
    	$user->unreadNotifications->markAsRead();
    	return redirect(url('/notifications'));
    }

    /**
     * Backend controller for the notification_center module
     *
     * @author Oliver G.
     * @return view
     * @category AntelopeNotifications
     * @version 1.0.0
     */
    public function view()
    {
    	$notifications = auth()->user()->notifications->skip(0)->take(30);
    	return view('notification_center')->with('constants', $this->constants)
    									  ->with('notifications', $notifications);
    }
}
