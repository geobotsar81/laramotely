<?php
namespace App\Services;

use App\Models\Job;
use App\Models\Email;
use App\Mail\NewsletterMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class NewsletterService
{
    /**
     * Loop through the subscribed email addresses and send the daily newsletter
     *
     * @return void
     */
    public function sendEmails(): void
    {
        $jobs = Job::laravel()
            ->published()
            ->notother()
            ->whereDate("created_at", ">=", Carbon::yesterday())
            ->whereDate("posted_date", ">=", Carbon::yesterday())
            ->orderBy("posted_date", "desc")
            ->take(10)
            ->get();
        $contacts = Email::where("is_subscribed", 1)->get();

        if (!empty($jobs)) {
            if (!empty($contacts)) {
                foreach ($contacts as $contact) {
                    Mail::to($contact->email)->send(new NewsletterMail($jobs, $contact));
                    echo $contact->email;
                    echo $jobs->count() . " jobs";
                    echo $contacts->count() . " contacts";
                }
            }
        }
    }
}
