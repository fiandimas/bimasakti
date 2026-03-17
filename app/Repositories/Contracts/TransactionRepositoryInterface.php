<?php

namespace App\Repositories\Contracts;

interface TransactionRepositoryInterface
{
    public function index(string $search);
}