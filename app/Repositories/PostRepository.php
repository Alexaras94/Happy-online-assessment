<?php

namespace App\Repositories;

use App\DTOs\FilterDTO;
use App\DTOs\PostDTO;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\PostRepositoryInterface;




class PostRepository implements PostRepositoryInterface
{
    private Post $model;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function getAll(FilterDTO $filterDTO): LengthAwarePaginator
    {
        return $this->model
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select(
                'posts.id',
                'posts.user_id',
                'posts.title',
                'posts.slug',
                'posts.content',
                'posts.created_at',
                'posts.updated_at',
                'users.email as author_name'
            )

            ->with(['tags', 'categories','comments'])

            // 3. WHEN: Conditional Filtering
            ->when($filterDTO->authorId, function ($query) use ($filterDTO) {
                return $query->where('posts.user_id', $filterDTO->authorId);
            })

            ->when($filterDTO->author, function ($query) use ($filterDTO) {
                return $query->where('users.email', 'like', '%' . $filterDTO->author . '%');
            })

            ->when($filterDTO->authorId, function ($query) use ($filterDTO) {
                return $query->where('posts.user_id', $filterDTO->authorId);
            })
            ->when($filterDTO->tag, function ($query) use ($filterDTO) {
                return $query->whereHas('tags', function ($q) use ($filterDTO) {
                    $q->where('name', 'like', '%' . $filterDTO->tag . '%');
                });
            })
            ->when($filterDTO->category, function ($query) use ($filterDTO) {
                return $query->whereHas('categories', function ($q) use ($filterDTO) {
                    $q->where('name', 'like', '%' . $filterDTO->category . '%');
                });
            })

            ->orderBy('posts.created_at', 'desc')


            ->paginate($filterDTO->perPage);
        //
    }

    public function getById(string $id): Post
    {
        return $this->model->with(['user', 'tags', 'categories', 'comments'])
            ->where('id', $id)
            ->firstOrFail();

    }

    public function create(PostDTO $postDTO): Post
    {
        return $this->model->create($postDTO->toArray());
    }

    public function update(Post $post, PostDTO $postDTO): Post
    {
        $post->update(array_filter($postDTO->toArray(), fn($value) => !is_null($value)));

        return $post;
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function syncTags(Post $post, array $tags): void
    {
        $post->tags()->sync($tags);
    }

    public function syncCategories(Post $post, array $categories): void
    {
        $post->categories()->sync($categories);
    }
}
