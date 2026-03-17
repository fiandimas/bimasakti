<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquents\OrderRepository;


use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Eloquents\TransactionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }
}