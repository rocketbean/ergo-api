<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobOrderAttachment extends Notification
{
    use Queueable;
    public $jo, $jr, $subject, $type, $body;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jo, $jr, $subject)
    {
        $this->jo = $jo;
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
            'title'     => $this->subject->name,
            'message'   => $this->subject->name . ' posted an update.',
            'subject' => $this->subject->id,
            'subject_type' => class_basename($this->subject), 
            '_modals'   => (object) ['joborderModal' => (object) ['open'=> true, 'data' => ['jobrequest' => $this->jr->id, 'joborder' => $this->jo->id ]]]
        ];
    }
}
