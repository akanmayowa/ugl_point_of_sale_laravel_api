<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexOrderInventoryRequest;
use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\IndexOrderUserRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTraits;
    protected $orderServices;
    public function __construct(OrderServices $orderServices)
    {
        $this->orderServices = $orderServices;
    }

    public function index(IndexOrderRequest  $indexOrderRequest): JsonResponse
    {
        return $this->orderServices->index($indexOrderRequest->all());
    }

    public function store(StoreOrderRequest $storeOrderRequest)
    {
        return $this->orderServices->store($storeOrderRequest->all());
    }

    public function show($id): JsonResponse
    {
        return $this->orderServices->show($id);
    }

    public function orderDetails(Request $request): JsonResponse
    {
        return $this->orderServices->orderDetails($request->all());
    }

    public function orderTransaction(Request $request): JsonResponse
    {
        return $this->orderServices->orderTransaction($request->all());
    }

    public function fetchAllInventory(IndexOrderInventoryRequest  $indexOrderInventoryRequest): JsonResponse
    {
        $response = $this->orderServices->fetchAllInventory($indexOrderInventoryRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '');
    }

    public function fetchAllCustomer(Request  $request): JsonResponse
    {
      return $this->orderServices->fetchAllCustomer($request->all());
    }

    public function fetchAllOrders(Request $request): JsonResponse
    {
        return $this->orderServices->fetchAllOrders($request->all());
    }


    public  function getCashierByOrderId(IndexOrderUserRequest $indexOrderUserRequest): array
    {
        return $this->orderServices->getCashierByOrderId($indexOrderUserRequest->validated());
    }


}
