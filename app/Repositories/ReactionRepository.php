<?php

namespace App\Repositories;

use App\Models\Reaction;

class ReactionRepository
{
    public function create(array $data): Reaction
    {
        return Reaction::create($data);
    }

   
    public function findByPostAndUser(int $postId, int $userId): ?Reaction
    {
        return Reaction::where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();
    }

    public function delete(Reaction $reaction): bool
    {
        return $reaction->delete();
    }

    public function getCountByPostId(int $postId): int
    {
        return Reaction::where('post_id', $postId)->count();
    }
}
