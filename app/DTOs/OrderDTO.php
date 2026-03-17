<?php

namespace App\DTOs;

use App\Http\Requests\OrderRequest;

class OrderDTO
{
    public function __construct(
        public readonly int $amount,
        public readonly string $reff,
        public readonly string $expiredAt,
        public readonly string $name,
        public readonly string $phone,
    ) {}

    public static function fromRequest(OrderRequest $request): self {
        return new self(
            amount: $request->validated('amount'),
            reff: $request->validated('reff'),
            expiredAt: $request->validated('expired_at'),
            name: $request->validated('name'),
            phone: $request->validated('phone'),
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'reff' => $this->reff,
            'expired_at' => $this->expiredAt,
            'name' => $this->name,
            'phone' => $this->phone,
        ];
    }
}