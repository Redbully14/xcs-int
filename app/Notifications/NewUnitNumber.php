<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NewUnitNumber extends Notification
{
    public $constants;
    public $oldNumber;
    public $newAccess;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($oldNumber, $newNumber)
    {
        $this->constants = \Config::get('constants');
        $this->oldNumber = $oldNumber;
        $this->newNumber = $newNumber;
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
            'title' => 'Unit Number Changed',
            'text' => 'Your Unit Number has been changed from '.$this->oldNumber." to ".$this->newNumber.".",
            'icon' => 'mdi mdi-account-card-details',
            'color' => 'primary',
        ];
    }
}
