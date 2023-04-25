<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerTypeRequest;
use App\Http\Requests\IndexCustomerRequest;
use App\Http\Requests\IndexPriceTypeRequest;
use App\Http\Requests\ShowBusinessSegmentRequest;
use App\Http\Requests\ShowCustomerRequest;
use App\Http\Requests\ShowCustomerTypeRequest;
use App\Http\Requests\StoreBusinessSegmentRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\StoreCustomerTypeRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\CustomerServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    private $customerServices;

    public function __construct(CustomerServices $customerServices)
    {
        $this->customerServices = $customerServices;
    }

    public function index(IndexCustomerRequest $indexCustomerRequest)
    {
       return $this->customerServices->index($indexCustomerRequest->validated());
    }

    public function store(StoreCustomerRequest $storeCustomerRequest)
    {
        return $this->customerServices->store($storeCustomerRequest->validated());
    }

    public function update(UpdateCustomerRequest $storeCustomerRequest)
    {
        return $this->customerServices->update($storeCustomerRequest->validated());
    }

    public function indexCustomerType(CustomerTypeRequest $CustomerTypeRequest)
    {
        return $this->customerServices->indexCustomerType($CustomerTypeRequest->validated());
    }

    public function storeCustomerType(StoreCustomerTypeRequest $storeCustomerTypeRequest)
    {
        return $this->customerServices->storeCustomerType($storeCustomerTypeRequest->validated());
    }

    public function delete($id)
    {
        return $this->customerServices->delete($id);
    }

    public function show(ShowCustomerRequest $showCustomerRequest)
    {
        return $this->customerServices->show($showCustomerRequest->all());
    }

    public function deleteCustomerType($id): JsonResponse
    {
        return $this->customerServices->deleteCustomerType($id);
    }

    public function deleteBusinessSegment($id)
    {
        return $this->customerServices->deleteBusinessSegment($id);
    }

    public function indexBusinessSegment()
    {
        return $this->customerServices->indexBusinessSegment();
    }

    public function storeBusinessSegment(StoreBusinessSegmentRequest $storeBusinessSegmentRequest)
    {
        return $this->customerServices->storeBusinessSegment($storeBusinessSegmentRequest->all());
    }

    public function showBusinessSegment(ShowBusinessSegmentRequest $showBusinessSegmentRequest)
    {
        return $this->customerServices->showBusinessSegment($showBusinessSegmentRequest->all());
    }

    public function showCustomerType(ShowCustomerTypeRequest $showCustomerTypeRequest)
    {
        return $this->customerServices->showCustomerType($showCustomerTypeRequest->all());
    }

    public function fetchCustomerType()
    {
        return $this->customerServices->fetchAllCustomerType();
    }

    public function getPriceType(IndexPriceTypeRequest $indexPriceTypeRequest)
    {
        return $this->customerServices->getPriceType($indexPriceTypeRequest->all());
    }


}
