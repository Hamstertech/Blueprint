<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'stripe_id' => $this->stripe_id,
            'created_at' => $this->created_at,
            'last_login' => $this->last_login,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
