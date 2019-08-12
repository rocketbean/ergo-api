<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewJobRequest extends Notification
{
    use Queueable;
    public $jo, $jr, $subject, $type, $body;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $jr )
    {
        $this->jr = $jr;
        $this->subject = $subject;
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
    public function toDatabase($notifiable)
    {
        return [
            'title'     => $this->jr->name,
            'message'   => $this->subject->name . ' added a jobrequest',
            'subject' => $this->subject->id,
            'subject_type' => class_basename($this->subject),
            '_modals'   => (object) ['addJrItem' => (object) ['open'=> true, 'data' => ['jobrequest' => $this->jr->id]]]
        ];
    }
}
