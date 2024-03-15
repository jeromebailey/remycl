<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VitalSyncMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject, $body, $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $view)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        return $this->from('donotreply@my-vitals.com', 'My-Vitals')
        ->subject($this->subject)
        ->view($this->view, ['mail_data' => $this->body]);
    }
}
