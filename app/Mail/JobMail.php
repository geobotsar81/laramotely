<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobMail extends Mailable
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
        return $this->from("info@laramotely.com")
            ->markdown("jobform")
            ->with([
                "subject" => $this->form["subject"],
                "jobTitle" => $this->form["jobTitle"],
                "jobCompany" => $this->form["jobCompany"],
                "jobUrl" => $this->form["jobUrl"],
                "jobTags" => $this->form["jobTags"],
                "jobDescription" => $this->form["jobDescription"],
                "jobLocation" => $this->form["jobLocation"],
                "jobEmail" => $this->form["jobEmail"],
            ]);
    }
}
