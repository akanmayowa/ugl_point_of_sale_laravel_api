<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexDebtorCustomerOrderRequest;
use App\Http\Requests\IndexDebtorRequest;
use App\Services\Cashier\DebtorServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class DebtorController extends Controller
{
    use ResponseTraits;
    protected $debtorServices;
    public function __construct(DebtorServices $debtorServices)
    {
        $this->debtorServices = $debtorServices;
    }


    public function index(IndexDebtorRequest $indexDebtorRequest)
    {
        $response =   $this->debtorServices->index($indexDebtorRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }


    public function fetchAllCustomerOrders(IndexDebtorCustomerOrderRequest $indexDebtorCustomerOrderRequest)
    {
        $response =   $this->debtorServices->fetchAllCustomerOrders($indexDebtorCustomerOrderRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);

    }
}
