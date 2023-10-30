<?php

namespace App\Listeners;

use App\Events\welcomeUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\TestMail2;
use Illuminate\Support\Facades\Mail;

class sendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  welcomeUser  $event
     * @return void
     */
    public function handle(welcomeUser $event)
    {
        //
        Mail::to('ahmedessame26@gmail.com','ahmed')->send(new TestMail2($event->grade));

    }
}
