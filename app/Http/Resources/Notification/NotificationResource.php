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
        $dest = '';

        switch ($this->model) {
            case 'Article':
                if ($this->model_id) {
                    $dest = 'article.view';
                } else {
                    $dest = 'articles.index';
                }
                break;
            
            case 'Brand':
                $dest = 'users.account';
                break;

            case 'Chat':
                if ($this->model_id) {
                    $dest = 'chat.view';
                } else {
                    $dest = 'chats.index';
                }
                break;

            case 'FAQ':
                $dest = 'help.faq';
                break;

            case 'HelpTicket':
                if ($this->model_id) {
                    $dest = 'ticket.view';
                } else {
                    if (auth()->user()->role_id >= 1 && auth()->user()->role_id <= 3) {
                        $dest = 'tickets.list';
                    } else {
                        $dest = 'help.index';
                    }
                }
                break;

            case 'Property':
                if ($this->model_id) {
                    $dest = 'property.view';
                } else {
                    $dest = 'properties.index';
                }
                break;

            case 'PropertyLog':
                if ($this->model_id) {
                    $dest = 'property.logs';
                } else {
                    $dest = 'properties.index';
                }
                break;

            case 'PropertyUnit':
                if ($this->model_id) {
                    $dest = 'unit.view';
                } else {
                    $dest = 'properties.index';
                }
                break;

            case 'PropertyReview':
                if ($this->model_id) {
                    $dest = 'review.view';
                } else {
                    $dest = 'properties.index';
                }
                break;

            case 'SubZone':
                if ($this->model_id) {
                    $dest = 'sub-zone.view';
                } else {
                    $dest = 'zones.index';
                }
                break;

            case 'Tag':
                if ($this->model_id) {
                    $dest = 'tags.index';
                }
                break;

            case 'Transaction':
                if ($this->model_id) {
                    $dest = 'transactions.mine';
                }
                break;
            
            case 'User':
                if (auth()->user()->role_id >= 1 && auth()->user()->role_id <= 3) {
                    if ($this->model_id) {
                        $dest = 'user.manage';
                    } else {
                        $dest = 'users.index';
                    }
                }
                break;
            
            case 'UserActivityLog':
                if (auth()->user()->role_id >= 1 && auth()->user()->role_id <= 3) {
                    $dest = 'users.logs';
                }
                break;
            
            case 'Zone':
                if ($this->model_id) {
                    $dest = 'zone.view';
                } else {
                    $dest = 'zones.index';
                }
                break;
        }

        return [
            'id' => $this->id, 
            'title' => $this->title, 
            'body' => $this->body, 
            'thumbnail' => $this->thumbnail, 
            'dest' => $dest, 
            'dest_link' => $this->model_id, 
            'read' => boolval($this->read), 
            'user' => User::findOrFail($this->user_id)->username, 
            'time_ago' => $this->created_at->diffForHumans()
        ];
    }
}
