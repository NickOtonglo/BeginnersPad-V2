<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::where('id', $this->user_id)->first();
        $properties = Property::where('user_id', $this->user_id)->get();
        $ratingCollection = [];
        $ratingAverage = 0;
        foreach ($properties as $property) {
            array_push($ratingCollection, $property->propertyReviews()->avg('rating'));
        }
        try {
            $ratingAverage = array_sum($ratingCollection)/count($ratingCollection);
        } catch (\Throwable $th) {
            $ratingAverage = 0;
        }
        
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'statement' => $this->statement,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at->format('j F Y'),
            'properties_count' => count($properties),
            'username' => $user->username,
            'rating' => number_format($ratingAverage, 1),
        ];
    }
}
