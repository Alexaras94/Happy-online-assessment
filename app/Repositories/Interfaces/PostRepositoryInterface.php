<?php

namespace App\Repositories\Interfaces;

use App\DTOs\FilterDTO;
use App\DTOs\PostDTO;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getAll(FilterDTO $filterDTO): LengthAwarePaginator;
    public function create(PostDTO $postDTO): Post;
    public function update(Post $post, PostDTO $postDTO): Post;
    public function delete(Post $post): void;
    public function syncTags(Post $post, array $tags): void;
    public function syncCategories(Post $post, array $categories): void;
}
