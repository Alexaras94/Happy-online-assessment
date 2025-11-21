<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,

            'author' => [
                'id' => $this->user_id,
                'email' => $this->author_email ?? $this->user?->email,
            ],

            'tags' => TagResource::collection($this->whenLoaded('tags')),

            'categories' => CategoryResource::collection($this->whenLoaded('categories')),

            'comments' => CommentResource::collection($this->whenLoaded('comments')),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
