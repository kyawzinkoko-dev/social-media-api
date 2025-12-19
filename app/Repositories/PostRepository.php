<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{

    public function create(array $data): Post
    {
        return Post::create($data);
    }


    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post->fresh();
    }

    public function findById(int $id): ?Post
    {
        return Post::find($id);
    }


    public function getAllWithCounts(int $perPage = 15): LengthAwarePaginator
    {
        return Post::with(['user:id,name'])
            ->withCount(['reactions', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }


    public function getByUserId(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Post::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }


    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
