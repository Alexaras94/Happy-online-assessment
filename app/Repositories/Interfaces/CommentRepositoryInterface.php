<?php

namespace App\Repositories\Interfaces;

use App\DTOs\CommentDTO;
use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

interface CommentRepositoryInterface
{

    public function create(CommentDTO $commentDTO): Comment;
    public function getByUserId(int $userId): LengthAwarePaginator;

}
