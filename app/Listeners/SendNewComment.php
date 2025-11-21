<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewComment
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
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;


        $post = $comment->post;
        $author = $post->user;

      //If the author Comments dont Send Email
        if ($author && $author->id !== $comment->user_id) {

            $author->notify(new NewCommentNotification($comment, $post));
        }
    }
}
