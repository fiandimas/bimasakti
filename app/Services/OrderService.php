<?php

namespace App\Services;

use App\DTOs\OrderDTO;
use App\Exceptions\PaymentException;
use App\Jobs\ProcessPaidOrder;
use App\Models\Order;
use App\Repositories\Eloquents\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository) {}

    public function index(string $search)
    {
        return $this->orderRepository->index($search);
    }

    public function store(OrderDTO $dto): Order
    {
        $finalAmount = $dto->amount + Order::ORDER_FEE;
        $code = Order::COMPANY_CODE . $dto->phone;

        return $this->orderRepository->create(array_merge($dto->toArray(), [
            'amount' => $finalAmount,
            'code' => $code,
        ]));
    }

    public function payment(string $reff, string $status): Order
    {
        $order = $this->orderRepository->findByReff($reff);
        if (is_null($order)) {
            throw new PaymentException('Order not found');
        }

        if ($order->status === Order::ORDER_PAID) {
            throw new PaymentException('Order already paid');
        } else if ($order->status === Order::ORDER_EXPIRED) {
            throw new PaymentException('Order already expired');
        }

        $affected = $this->orderRepository->updateStatus($reff, $status);
        if (!$affected) {
            throw new PaymentException('Failed to update order status');
        }

        $order = $this->orderRepository->findByReff($reff);
        ProcessPaidOrder::dispatch($order);

        return $order;
    }

    public function status(string $reff): Order
    {
        $order = $this->orderRepository->findByReff($reff);
        if (is_null($order)) {
            throw new PaymentException('Order not found');
        }

        return $order;
    }
}