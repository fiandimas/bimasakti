<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function index(string $search);
    public function create(array $data): Order;
    public function findByReff(string $reff): ?Order;
    public function updateStatus(string $reff, string $status): bool;
}