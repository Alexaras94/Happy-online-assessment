<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CommentFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(10)->create();

        $categories=Category::factory(10)->create();

        Category::factory(3)->create(
            [
                'parent_id' => $categories->random()->id,
            ]
        );

        $tags=Tag::factory(10)->create();

        $posts=Post::factory(10)->create(
            [
                'user_id' => $users->random()->id,
            ]
        );

        //Add Tags to Posts Many to Many

        $posts->each(function ($post) use ($tags,$categories) {
           $post->tags()->attach(
               $tags->random(rand(1,3))->pluck('id')->toArray()  //add random 1 till 3 tags to every post
           ) ;
            $post->categories()->attach(
                $categories->random(rand(1,5))->pluck('id')->toArray()  //add random 1 till 3 tags to every post
            ) ;

        });


        //Comments to Users
        //comments to posts

        for($i=0;$i<10;$i++){
            Comment::factory()->create([
                'post_id' => $posts->random()->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
