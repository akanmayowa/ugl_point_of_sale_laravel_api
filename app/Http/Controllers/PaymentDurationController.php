<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowPaymentDurationRequest;
use App\Http\Requests\StorePaymentDurationRequest;
use App\Services\PaymentDurationServices;
use Illuminate\Http\Request;

class PaymentDurationController extends Controller
{
    private $paymentDurationServices;

    public function __construct(PaymentDurationServices $paymentDurationServices)
    {
        $this->paymentDurationServices = $paymentDurationServices;
    }

    public function index(Request $request)
    {
        return $this->paymentDurationServices->index();
    }

    public function show(ShowPaymentDurationRequest $showPaymentDurationRequest)
    {
        return $this->paymentDurationServices->show($showPaymentDurationRequest->all());
    }

    public function store(StorePaymentDurationRequest $storePaymentDurationRequest)
    {
        return $this->paymentDurationServices->store($storePaymentDurationRequest->all());
    }

    public function delete($id)
    {
       return $this->paymentDurationServices->delete($id);
    }
}
