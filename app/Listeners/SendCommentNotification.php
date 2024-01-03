<?php

namespace App\Listeners;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostCommented;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCommentNotification
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
    public function handle(object $event): void
    {
        //dd($event->commentNotificationDto);
        Notification::send($event->commentNotificationDto->postOwner,new PostCommented($event->commentNotificationDto));
    }
}
