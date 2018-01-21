<?php

namespace App\Listeners;

use App\Events\PersonalAlertCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class SendPersonalAlert
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
     * @param  PersonalAlertCreated  $event
     * @return void
     */
    public function handle(PersonalAlertCreated $event)
    {
        $post = $event->post;
        $triggered_user = $event->triggered_user;
        $data = $event->data;

        Mail::to($post->user)
            ->queue(new SendMail($post, $triggered_user, $data));
    }
}
