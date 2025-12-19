<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

   
    public function store(CommentRequest $request, int $postId): JsonResponse
    {
        $userId = Auth::id();
        $comment = $this->commentService->createComment($postId, $request->validated(), $userId);

        if (!$comment) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($comment, 201);
    }
}
