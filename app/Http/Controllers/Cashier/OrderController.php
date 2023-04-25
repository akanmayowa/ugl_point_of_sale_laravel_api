<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\IndexOrderRequest;
use App\Services\Cashier\OrderServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTraits;
    private $orderService;

    public function __construct(OrderServices $orderService,)
     {
         $this->orderService = $orderService;
     }

     public function index(IndexOrderRequest $indexOrderRequest)
     {
         $response = $this->orderService->index($indexOrderRequest->validated());
         return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
     }

     public function fetchAllCashierOrders($indexOrderRequest): JsonResponse
     {
         $response = $this->orderService->index($indexOrderRequest->fetchAllCashierOrders());
         return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
     }


}
