<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Post;
use App\User;


class SendMail extends Mailable
{
    public $post;
    public $triggered_user;
    public $data;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $triggered_user, $data)
    {
        $this->post = $post;
        $this->triggered_user = $triggered_user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.alert')
            ->subject(env('APP_NAME').'からの通知')
            ->with([
                'to_user' => $this->to[0],
            ]);
    }
}
