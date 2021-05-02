<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskItemIssueResolvedNotification extends Notification
{
    use Queueable;

    public $taskTitle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($taskTitle)
    {
        $this->taskTitle = $taskTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Item Issue Resolved')
            ->view('vendor.notifications.task-item-resolve', [
                'fullName' => $notifiable->name, 'taskTitle' => $this->taskTitle
            ]);
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
            //
        ];
    }
}
