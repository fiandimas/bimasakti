<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\OrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\StatusResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(Request $request)
    {
        $orders = $this->orderService->index($request->query('search', ''));
        return $orders->toArray();
    }

    public function order(OrderRequest $request)
    {
        $order = $this->orderService->store(OrderDTO::fromRequest($request));
        return OrderResource::make($order);
    }

    public function payment(PaymentRequest $request)
    {
        $order = $this->orderService->payment($request->reff, $request->status);
        return PaymentResource::make($order);
    }

    public function status(Request $request)
    {
        $order = $this->orderService->status($request->query('reff'));
        return StatusResource::make($order);
    }
}
