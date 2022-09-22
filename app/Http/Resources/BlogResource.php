<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => ucfirst($this->title),
            'description' => Str::limit($this->description, 30),
            'image_path' => $this->image ?? null,
            'is_published' => (bool)$this->is_published,
            'created_by' => $this->user->name,
            'created_at' => $this->created_at->diffForHumans()
        ];

    }
}
