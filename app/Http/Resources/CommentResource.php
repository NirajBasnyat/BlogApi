<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => ucfirst($this->title),
            'body' => Str::limit($this->body, 20),
            'comment_by' => $this->user->name,
            'blog_id' => $this->blog->id
        ];
    }
}
