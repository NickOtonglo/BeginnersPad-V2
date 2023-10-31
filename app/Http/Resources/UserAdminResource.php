<?php

namespace App\Http\Resources;

use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $suspendedCount = UserLog::where('user_id', $this->id)->where('status', 'suspended')->get()->count();

        // $logs = [];
        // foreach ($this->logsParent as $item) {
        //     array_push($logs, $item->userLog);
        // }

        // $logsParent = [];
        // foreach ($this->logsParent as $item) {
        //     array_push($logsParent, $item);
        // }

        $logs = UserLog::where('user_id', $this->id)->get();

        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'username' => $this->username,
            'telephone' => $this->telephone,
            'role' => $this->role->title,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'count_suspended' => $suspendedCount,
            'created_at' => $this->created_at->format('j F Y'),
            'brand' => new BrandResource($this->brand),
            // 'logs_parent' => $logsParent,
            'logs' => UserLogResource::collection($logs),
        ];
    }
}
