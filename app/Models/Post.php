<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */



    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_id',
        'category_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
