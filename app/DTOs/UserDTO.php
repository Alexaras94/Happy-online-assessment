<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class UserDTO extends Data
{

    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {}


}
