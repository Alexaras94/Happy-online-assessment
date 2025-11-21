<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class CommentDTO extends Data
{
    public function __construct(

        public string $content,

        public ?int $post_id=null,

        public ?int $user_id = null,
    ) {}
}
