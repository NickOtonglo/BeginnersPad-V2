<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCreditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'user' => $user->username,
            'credit' => $this->credit,
            'auto_pay' => boolval($this->auto_pay),
            'timestamp' => $this->updated_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->updated_at->diffForHumans(),
        ];
    }
}
