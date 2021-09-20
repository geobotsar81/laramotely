<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->form = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@laramotely.com')
                ->markdown('contactform')
                ->with([
                        'subject' => $this->form['subject'],
                        'message' => $this->form['message'],
                        'email' => $this->form['email'],
                        'fullname' => $this->form['fullname'],
                    ]);
    }
}
