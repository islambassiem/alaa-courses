<?php

namespace App\Listeners;

use App\Events\UserEnrolled as Event;
use Illuminate\Support\Facades\Mail;

class UserEnrolled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Event $event): void
    {
        Mail::to($event->user)->send(new \App\Mail\UserEnrolled($event->course, $event->user));
    }
}
