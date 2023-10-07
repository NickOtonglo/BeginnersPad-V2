<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $author = $this->user->username;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            // 'preview' => substr($this->preview, 0, 500).'...',
            'preview' => substr($this->preview, 0, 650),
            'content' => $this->content,
            'author' => $author,
            'thumbnail' => $this->thumbnail,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
        ];
    }
}
