<?php

namespace App\Services\Interfaces;

use App\DTOs\FilterDTO;
use App\DTOs\PostDTO;
use App\DTOs\UserDTO;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{

    public function handleAll (FilterDTO $filters): LengthAwarePaginator;
    public function handleById(string $id): Post;

    public function handleCreate (PostDTO $data): Post;
    public function handleUpdate (Post $post, PostDTO $data): Post;

    public function handleDelete (Post $post): void;
}
