<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->amount,
            'reff' => $this->reff,
            'name' => $this->name,
            'phone' => $this->phone,
            'code' => $this->code,
            'expired_at' => $this->expired_at,
        ];
    }
}
