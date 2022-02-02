<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Page;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    /**
     * Display the contact page
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug = "contact"): Response
    {
        $cacheDuration = env("CACHE_DURATION");
        $page = Cache::remember("page.slug." . $slug, $cacheDuration, function () use ($slug) {
            return Page::where(["slug" => $slug, "status" => "ACTIVE"])->firstOrFail();
        });

        return Inertia::render("Contact/Index", [
            "page" => $page,
        ])->withViewData(["title" => $page->title, "description" => $page->meta_description, "url" => $page->slug]);
    }

    /**
     * Validate the contact form and send the contact email
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendMail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "contactName" => "required",
            "contactEmail" => "email:rfc,dns",
            "contactMessage" => "required",
            "honeypot" => "present|max:0",
        ]);

        $contact = [
            "fullname" => $request["contactName"],
            "email" => $request["contactEmail"],
            "subject" => "Contact Form email",
            "message" => $request["contactMessage"],
        ];

        Mail::to("info@laramotely.com")->send(new ContactFormMail($contact));
        return redirect()
            ->route("contact.show")
            ->with("status", "Your message has been sent");
    }
}
