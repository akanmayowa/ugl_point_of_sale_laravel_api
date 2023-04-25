<?php

namespace App\Http\Controllers;

use App\Http\Requests\customerDebtPaymentRequest;
use App\Http\Requests\IndexDebtorCustomerOrderRequest;
use App\Http\Requests\IndexDebtorRequest;
use App\Http\Requests\ShowDebtorRequest;
use App\Http\Requests\StoreDebtorRequest;
use App\Services\DebtorServices;
use Illuminate\Http\Request;

class DebtorController extends Controller
{

    protected $debtorServices;
    public function __construct(DebtorServices $debtorServices)
    {
          $this->debtorServices = $debtorServices;
    }

    public function index(IndexDebtorRequest $indexDebtorRequest)
    {
        return $this->debtorServices->index($indexDebtorRequest->all());
    }

    public function store(StoreDebtorRequest $storeDebtorRequest)
    {
        return $this->debtorServices->store($storeDebtorRequest->all());
    }

    public function show(ShowDebtorRequest $showDebtorRequest)
    {
        return $this->debtorServices->show($showDebtorRequest->all());
    }

    public function delete($id)
    {
        return $this->debtorServices->delete($id);
    }

    public function customerDebtPayment(customerDebtPaymentRequest $customerDebtPaymentRequest)
    {
        return $this->debtorServices->customerDebtPayment($customerDebtPaymentRequest->all());
    }

   public function showDebtor(showDebtorRequest $showDebtorRequest)
    {
        return $this->debtorServices->customerDebtPayment($showDebtorRequest->all());
    }

    public function fetchAllOrders(IndexDebtorCustomerOrderRequest $indexDebtorCustomerOrderRequest)
    {
        return $this->debtorServices->fetchAllOrders($indexDebtorCustomerOrderRequest->validated());
    }


}
