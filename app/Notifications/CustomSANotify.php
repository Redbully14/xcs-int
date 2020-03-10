<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomSANotify extends Notification
{
    public $title;
    public $text;
    public $icon;
    public $color;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $text, $icon, $color)
    {
        $this->title = $title;
        $this->text = $text;
        $this->icon = $icon;
        $this->color = $color;
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
            'title' => $this->title,
            'text' => $this->text,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}
