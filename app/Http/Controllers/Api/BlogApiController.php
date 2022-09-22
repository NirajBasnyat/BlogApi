<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogApiRequest;
use App\Http\Resources\BlogResource;
use App\Traits\HttpResponse;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogApiController extends Controller
{
    use HttpResponse;

    public function index(): ?JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('access_blogs')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        return $this->successResponse(BlogResource::collection(Blog::all()), 'Blog List');
    }

    public function store(BlogApiRequest $request): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('create_blog')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        $blog = auth()->user()->blogs()->create($request->validated());

        if ($request->hasFile('image')) {
            $filename = 'blog-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $blog->storeImage($request->file('image')->storeAs('blog-image', $filename, 'public'), 'single');
        }

        return $this->successResponse(new BlogResource($blog), 'Blog created successfully', 201);
    }

    public function show(Blog $blog): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('view_blog_post')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        if ($this->checkAuthorizedUser($blog, 'user_id')) {

            return $this->successResponse(new BlogResource($blog), 'Single Blog Post');
        }

        return $this->errorResponse(null, 'Cannot view this item', 403);
    }

    public function update(BlogApiRequest $request, Blog $blog): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('update_blog')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        if ($this->checkAuthorizedUser($blog, 'user_id')) {
            $blog->update($request->validated());

            if ($request->hasFile('image')) {
                $filename = 'blog-' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                $blog->storeImage($request->file('image')->storeAs('blog-image', $filename, 'public'), 'single');
            }

            return $this->successResponse(new BlogResource($blog), 'Blog updated successfully');
        }

        return $this->errorResponse(null, 'Cannot update this blog item', 403);
    }

    public function destroy(Blog $blog): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('delete_blog')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        if ($this->checkAuthorizedUser($blog, 'user_id')) {
            $blog->delete();

            return $this->successResponse(null, 'Blog deleted successfully');
        }

        return $this->errorResponse(null, 'Cannot delete this blog item', 403);
    }

    public function myBlogs()
    {
        if (!auth()->user()->hasPermissionTo('access_my_blogs')) {
            return $this->errorResponse(null, 'You donot have right permissions', 401);
        }

        if (auth()->user()->is_admin == 1) {
            return $this->successResponse(BlogResource::collection(Blog::all()), 'Blog List');
        }

        return $this->successResponse(BlogResource::collection(Blog::where('user_id', auth()->id())->get()), 'Blog List');

    }
}
