<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\ReactionRepository;

class ReactionService
{
    protected $reactionRepository;
    protected $postRepository;

    public function __construct(
        ReactionRepository $reactionRepository,
        PostRepository $postRepository
    ) {
        $this->reactionRepository = $reactionRepository;
        $this->postRepository = $postRepository;
    }

    public function toggleReaction(int $postId, string $type, int $userId): ?array
    {
        $post = $this->postRepository->findById($postId);
        if (!$post) {
            return null;
        }

        $existingReaction = $this->reactionRepository->findByPostAndUser($postId, $userId);

        if ($existingReaction) {
            $this->reactionRepository->delete($existingReaction);
            $status = 'removed';
        } else {
            $this->reactionRepository->create([
                'post_id' => $postId,
                'user_id' => $userId,
                'type' => $type,
            ]);
            $status = 'added';
        }

       
        $reactionCount = $this->reactionRepository->getCountByPostId($postId);

        return [
            'status' => $status,
            'reaction_count' => $reactionCount,
        ];
    }
}
