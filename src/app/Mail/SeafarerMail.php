<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeafarerMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $mail_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {
        //
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('do-not-reply@seafarersregistry.ky', 'Cayman Islands Seafarers Registry')
        ->subject('Thank you for your Seafarer Contribution')
        ->view('mail.confirmation-email', ['mail_data' => $this->mail_data]);
    }
}
