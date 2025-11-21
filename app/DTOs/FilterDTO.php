<?php

namespace App\DTOs;
use Spatie\LaravelData\Data;

class FilterDTO extends Data
{
    public function __construct(

        public ?string $authorId = null,

        public ?string $author = null,

        public ?string $tag = null,

        public ?string $category = null,

        public int $perPage = 50,
    ) {}
}
