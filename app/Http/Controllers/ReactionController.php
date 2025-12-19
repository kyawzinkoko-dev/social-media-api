<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Services\ReactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    protected $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    
    public function toggle(ReactionRequest $request, int $postId): JsonResponse
    {
        $userId = Auth::id();
        $result = $this->reactionService->toggleReaction($postId, $request->input('type'), $userId);

        if (!$result) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($result, 200);
    }
}
