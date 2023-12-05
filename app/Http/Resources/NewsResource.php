<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'description' => $this->description,
            'content' => $this->content,
            'image' => $this->image,
            'published_at' => $this->published_at,
            'source' => $this->whenLoaded('source', new SourceResource($this->source)),
        ];
    }
}
