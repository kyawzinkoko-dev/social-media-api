<?php

namespace App\Services;

use App\Repositories\UserRepository;

class ProfileService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProfile(int $userId): array
    {
        $user = $this->userRepository->getUserWithCounts($userId);

        if (!$user) {
            return [];
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'post_count' => $user->posts_count,
            'reaction_count' => $user->reactions_count,
            'comment_count' => $user->comments_count,
        ];
    }
}
