<?php

namespace App\Http\Resources\Transaction;

use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        $gateway = PaymentGateway::find($this->payment_gateway_id);

        return [
            'id' => $this->id,
            'confirmation_code' => $this->confirmation_code,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'user' => $user->username,
            'payment_gateway' => $gateway->name,
            'timestamp' => $this->created_at->format('jS F Y, H:m:s'),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
