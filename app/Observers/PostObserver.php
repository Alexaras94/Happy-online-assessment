<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Tag;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $tag= Tag::firstOrCreate(['title' => 'new']);

        $post->tags()->syncWithoutDetaching([$tag->id]);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {

        if ($post->wasChanged(['title', 'content'])) {

        $tag = Tag::firstOrCreate(['title' => 'edited']);

        $post->tags()->syncWithoutDetaching([$tag->id]);
      }

    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
