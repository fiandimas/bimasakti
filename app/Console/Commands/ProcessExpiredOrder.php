<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ProcessExpiredOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-expired-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order to expired if the order is not paid after the expired time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('status', Order::ORDER_PENDING)
            ->where('expired_at', '<', now())
            ->update(['status' => Order::ORDER_EXPIRED]);
    }
}
