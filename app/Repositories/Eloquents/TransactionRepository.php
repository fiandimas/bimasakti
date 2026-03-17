<?php

namespace App\Repositories\Eloquents;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function index(string $search)
    {
        $query = Transaction::select('id', 'amount', 'reff', 'name', 'phone', 'status', 'code', 'paid_at');

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

        return $query->paginate(8);
    }
}