<?php

namespace App\Services;

use App\DTOs\FilterDTO;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DTOs\UserDTO;
use App\DTOs\PostDTO;
use Illuminate\Support\Str;

class PostService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository){
        $this->postRepository = $postRepository;
    }

    public function handleAll(FilterDTO $filterDTO): LengthAwarePaginator
    {
        $posts = $this->postRepository->getAll($filterDTO);

        return  $posts;
    }

    public function handleById(string $id): Post
    {
        return $this->postRepository->getById($id);
    }

    public function handleCreate(PostDTO $postDTO): Post
    {
        $postDTO->slug = Str::slug($postDTO->title) . '-' . time();

        $postDTO->user_id = auth('api')->id();

        $post = $this->postRepository->create($postDTO);
        if (!empty($data->tags)) {
            $this->postRepository->syncTags($post, $data->tags);
        }

        if (!empty($data->categories)) {
            $this->postRepository->syncCategories($post, $data->categories);
        }

        return $post->fresh(['tags', 'categories']);
    }

    public function handleUpdate(Post $post, PostDTO $postDTO): Post
    {
        if ($postDTO->title) {
            $postDTO->slug = Str::slug($postDTO->title) . '-' . time();
        }

        $updatedPost = $this->postRepository->update($post, $postDTO);

        if (!is_null($postDTO->tags)) {
            $this->postRepository->syncTags($updatedPost, $postDTO->tags);
        }

        if (!is_null($postDTO->categories)) {
            $this->postRepository->syncCategories($updatedPost, $postDTO->categories);
        }

        return $updatedPost->fresh(['tags', 'categories']);
    }

    public function handleDelete(Post $post): void
    {
        $this->postRepository->delete($post);
    }
}
