<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\OrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\StatusResource;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService) {}

    public function index(Request $request)
    {
        $transactions = $this->transactionService->index($request->query('search', ''));
        return $transactions->toArray();
    }
}
