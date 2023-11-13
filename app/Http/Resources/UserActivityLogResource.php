<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $log = [];

        if ($this->is_registered) {
            $log['user'] = User::where('email', $this->email)->first()->username;
        } else {
            $log['user'] = $this->email;
        }
        
        $log['is_registered'] = $this->is_registered ? 'true' : 'false';
        $log['method'] = $this->method;
        $log['model'] = $this->model;
        if ($this->model == 'HelpTicket') {
            $log['model_collection'] = $this->helpTicketLog;
        }
        if ($this->model == 'FAQ') {
            $log['model_collection'] = $this->faqLog;
        }
        if ($this->model == 'Zone') {
            $log['model_collection'] = $this->zoneLog;
        }
        if ($this->model == 'SubZone') {
            $log['model_collection'] = $this->subZoneLog;
        }
        if ($this->model == 'Property') {
            $log['model_collection'] = $this->propertyLog;
        }
        if ($this->model == 'PropertyUnit') {
            $log['model_collection'] = $this->propertyUnitLog;
        }

        return $log;
    }
}
