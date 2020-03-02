<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class Welcome extends Notification
{
    public $constants;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->constants = \Config::get('constants');
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
            'title' => 'Welcome',
            'text' => 'Welcome to AntelopePHP! Please let us know what you think about the new system through the Feedback Form!',
            'icon' => 'fab fa-asymmetrik rotate-n-15',
            'color' => 'info',
        ];
    }
}
