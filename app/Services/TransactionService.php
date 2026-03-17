<?php

namespace App\Services;

use App\Repositories\Eloquents\TransactionRepository;

class TransactionService
{
    public function __construct(private TransactionRepository $transactionRepository) {}

    public function index(string $search)
    {
        return $this->transactionRepository->index($search);
    }
}