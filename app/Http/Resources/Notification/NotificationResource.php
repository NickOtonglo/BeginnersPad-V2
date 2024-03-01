<?php

namespace App\Http\Resources\Notification;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'body' => $this->body, 
            'thumbnail' => $this->thumbnail, 
            'model' => $this->model, 
            'model_id' => $this->model_id, 
            'read' => boolval($this->read), 
            'user' => User::findOrFail($this->user_id)->username, 
        ];
    }
}
