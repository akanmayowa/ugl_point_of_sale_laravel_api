<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexReportCashierDaily;
use App\Http\Requests\IndexReportCashierDailyRequest;
use App\Http\Requests\IndexReportCustomerDebt;
use App\Http\Requests\IndexReportOrderDetailRequest;
use App\Http\Requests\IndexReportRequest;
use App\Http\Requests\IndexReportUserRequest;
use App\Services\ReportServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    use ResponseTraits;
    protected $reportServices;
    public function __construct(ReportServices $reportServices)
     {
         $this->reportServices = $reportServices;
     }


     public function dailyReport(IndexReportRequest $indexReportRequest)
     {
        return $this->reportServices->dailyReport($indexReportRequest->validated());
     }

     public function transactionReport(IndexReportRequest $indexReportRequest)
     {
         return $this->reportServices->transactionReport($indexReportRequest->validated());
     }

     public function cashierSalesReport(IndexReportRequest $indexReportRequest)
     {
         return $this->reportServices->cashierReport($indexReportRequest->validated());
     }

     public function fetchAllUser(IndexReportUserRequest $indexReportUserRequest)
     {
         $response = $this->reportServices->fetchAllUser($indexReportUserRequest->validated());
         return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
     }

    public function debtorReport(IndexReportCustomerDebt $indexReportCustomerDebt)
    {
        $response = $this->reportServices->debtorReport($indexReportCustomerDebt->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function cashierDailyReport(IndexReportCashierDailyRequest $indexReportCashierDailyRequest)
    {
        $response = $this->reportServices->cashierDailyReport($indexReportCashierDailyRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function orderDetailReport(IndexReportOrderDetailRequest $indexReportOrderDetailRequest)
    {
        $response = $this->reportServices->orderDetailReport($indexReportOrderDetailRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }


}
