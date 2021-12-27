<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Email;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class NewsletterController extends Controller
{

    /**
     * Unsubscribe a user from the email list and display the message
     *
     * @param String $encodedID
     * @return Response
     */
    public function unsubscribe(String $encodedID):Response
    {
        $meta=[];
        $userID=Crypt::decryptString($encodedID);

        if (!empty($userID)) {
            $email=Email::where('id', $userID)->first();
            if (!empty($email)) {
                $email->is_subscribed=0;
                $email->save();
                $message="User unsubscribed successfully.";
                $meta['messageCode']=1;
            } else {
                $message="Could not unsubscribe user. Please contact us to remove your email from our list.";
                $meta['messageCode']=0;
            }
        } else {
            $message="Could not unsubscribe user. Please contact us to remove your email from our list.";
            $meta['messageCode']=0;
        }


        $page=getPageFromSlug("unsubscribe");
        

        if (!empty($page)) {
            $meta=['title' => $page->title." - Laramotely",'description' => $page->meta_description,'url' =>route('newsletter.unsubscribe', $encodedID)];
        }

        $meta['message']=$message;

        return Inertia::render('Newsletter/Unsubscribe', $meta)->withViewData(['title' => $page->title,'description' => $page->meta_description,'url' => route('newsletter.unsubscribe', $encodedID)]);
    }

    /**
     * Validate the request and subscribe the user to the newsletter
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function subscribe(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:255',
            'honeypot' => 'present|max:0',
        ]);

        $email=Email::where('email', $request["email"])->first();

        if (!empty($email)) {
            $email->is_subscribed=1;
            $email->save();
        } else {
            $subscribe=new Email();
            $subscribe->email= $request["email"];
            $subscribe->save();
        }

        return redirect()->route('job.home')->with('status', 'You have successfully subscribed');
    }
}
