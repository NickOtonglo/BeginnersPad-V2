<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Property;
use App\Models\PropertyUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavouriteLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $source = '';
        if ($this->model == 'Property') {
            $source = new PropertyPublicResource(Property::where('id', $this->model_id)->first());
        }
        if ($this->model == 'PropertyUnit') {
            $source = new PropertyUnitLiteResource(PropertyUnit::where('id', $this->model_id)->first());
        }
        if ($this->model == 'Article') {
            $source = new ArticlesResource(Article::where('id', $this->model_id)->first());
        }

        return [
            // 'id' => $this->id,
            'title' => $this->title,
            'model' => $this->model,
            'data_slug' => $source->slug,
            'user' => auth()->user()->username,
        ];
    }
}
