<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $contact)
    {
        $this->jobs = $data;
        $this->contactLink = Crypt::encryptString($contact->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        echo "sending...";
        return $this->from("info@laramotely.com")
            ->markdown("newsletter")
            ->subject("Latest jobs on laramotely.com")
            ->with([
                "jobs" => $this->jobs,
                "contactLink" => $this->contactLink,
            ]);
    }
}
