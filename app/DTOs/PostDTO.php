<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class PostDTO extends Data
{
    public function __construct(
        public ?string $title = null,

        public ?string $content = null,

        public ?array $tags = null,

        public ?array $categories = null,

        public ?string $slug = null,

        public ?int $user_id = null,

    )
    {

    }


}
