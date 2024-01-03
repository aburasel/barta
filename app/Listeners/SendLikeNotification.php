<?php

namespace App\Listeners;

use App\Events\PostLiked;
use App\Models\User;
use App\Notifications\PostLiked as NotificationPostLiked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendLikeNotification
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
    public function handle(PostLiked $event): void
    {
        //dd($event->post);
        $postOwner= User::find($event->post->user_id);
        Notification::send($postOwner,new NotificationPostLiked($event->post));
    }
}
