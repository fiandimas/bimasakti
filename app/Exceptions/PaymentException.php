<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error'   => 'payment_exception',
            'message' => $this->getMessage(),
        ], 403);
    }
}
