<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexReportBusinessSegmentRequest;
use App\Http\Requests\IndexReportCustomerTypeRequest;
use App\Http\Requests\IndexReportInventoryOrProductTypeRequest;
use App\Http\Requests\IndexReportSalesTypeRequest;
use App\Services\ReportBetaServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportBetaController extends Controller
{
    use ResponseTraits;
    protected $reportBetaServices;

    public function __construct(ReportBetaServices $reportBetaServices){
        $this->reportBetaServices = $reportBetaServices;
    }

    public function salesTypeReport(IndexReportSalesTypeRequest $indexReportSalesTypeRequest): JsonResponse
    {
        $response = $this->reportBetaServices->salesTypeReport($indexReportSalesTypeRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function businessSegmentReport(IndexReportBusinessSegmentRequest $indexReportBusinessSegmentRequest): JsonResponse
    {
        $response = $this->reportBetaServices->businessSegmentReport($indexReportBusinessSegmentRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function customerTypeReport(IndexReportCustomerTypeRequest $indexReportCustomerTypeRequest): JsonResponse
    {
        $response = $this->reportBetaServices->customerTypeReport($indexReportCustomerTypeRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function InventoryOrProductTypeReport(IndexReportInventoryOrProductTypeRequest $indexReportInventoryOrProductTypeRequest): JsonResponse
    {
        $response = $this->reportBetaServices->InventoryOrProductTypeReport($indexReportInventoryOrProductTypeRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }



}
