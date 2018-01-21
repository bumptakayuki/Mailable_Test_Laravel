<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Post;
use App\User;

/**
 * Class PersonalAlertCreated
 * @package App\Events
 */
class PersonalAlertCreated
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Post
     */
    public $post;

    /**
     * @var User
     */
    public $triggered_user;

    /**
     * @var
     */
    public $data;


    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
