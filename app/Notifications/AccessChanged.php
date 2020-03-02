<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AccessChanged extends Notification
{
    public $constants;
    public $oldAccess;
    public $newAccess;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($oldAccess, $newAccess)
    {
        $this->constants = \Config::get('constants');
        $this->oldAccess = $oldAccess;
        $this->newAccess = $newAccess;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Access Changed',
            'text' => 'Your Antelope Access has been changed from '.$this->constants['role'][array_search($this->oldAccess, $this->constants['access_level'])]." to ".$this->constants['role'][$this->newAccess].".",
            'icon' => 'mdi mdi-account-key',
            'color' => 'warning',
        ];
    }
}
