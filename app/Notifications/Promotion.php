<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class Promotion extends Notification
{
    public $rank;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rank)
    {
        $this->rank = $rank;
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
            'title' => 'Promoted',
            'text' => 'You have been promoted to '.$this->constants['rank'][$this->rank].".",
            'icon' => 'mdi mdi-trophy-award',
            'color' => 'warning',
        ];
    }
}
