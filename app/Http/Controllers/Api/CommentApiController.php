<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentApiRequest;
use App\Http\Resources\CommentResource;
use App\Models\Blog;
use App\Models\Comment;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;

class CommentApiController extends Controller
{
    use HttpResponse;

    public function store(Blog $blog, CommentApiRequest $request): JsonResponse
    {
        $comment = $blog->comments()->create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return $this->successResponse(new CommentResource($comment), 'Comment created successfully', 201);
    }

    public function update(Blog $blog, Comment $comment, CommentApiRequest $request): JsonResponse
    {
        if($blog->id != $comment->blog_id){
            return $this->errorResponse(null, 'Comment Not Found', 404);
        }

        if ($this->checkAuthorizedUser($comment, 'user_id')) {

            $blog->comments()->update([
                'title' => $request->title,
                'body' => $request->body,
            ]);

            return $this->successResponse(new CommentResource($comment), 'Comment updated successfully');
        }

        return $this->errorResponse(null, 'Cannot update this comment not authorized', 403);
    }

    public function destroy(Blog $blog, Comment $comment): JsonResponse
    {
        if($blog->id != $comment->blog_id){
            return $this->errorResponse(null, 'Comment Not Found', 404);
        }

        if ($this->checkAuthorizedUser($comment, 'user_id')) {
            $comment->delete();
            return $this->successResponse(null, 'Comment updated successfully');
        }

        return $this->errorResponse(null, 'Cannot delete this Comment', 403);
    }
}
