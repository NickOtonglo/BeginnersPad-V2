<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserFavourite;
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
        // $favourite = UserFavourite::where('model', 'Article')->where('model_id', $this->id)->where('user_id', auth()->user()->id)->first();

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
            // 'favourite' => new UserFavouriteLiteResource($favourite),
        ];
    }
}
