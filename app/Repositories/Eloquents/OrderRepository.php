<?php

namespace App\Repositories\Eloquents;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function index(string $search)
    {
        $query = Order::select('id', 'amount', 'reff', 'name', 'phone', 'status', 'code', 'paid_at', 'expired_at');

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('reff', 'like', "%$search%")
                    ->orWhere('amount', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%")
                    ->orWhere('code', 'like', "%$search%");
            });
        }

        return $query->orderBy('updated_at', 'desc')->paginate(8);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function updateStatus(string $reff, string $status): bool
    {
        $updated = Order::where('reff', $reff)->update(['status' => $status, 'paid_at' => now()]);
        return $updated > 0;
    }

    public function findByReff(string $reff): ?Order
    {
        return Order::select('id', 'amount', 'reff', 'name', 'phone', 'status', 'code', 'paid_at', 'expired_at')->where('reff', $reff)->first();
    }
}