<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexDashboardRequest;
use App\Services\Cashier\DashboardServices;
use App\Traits\ResponseTraits;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{

    use ResponseTraits;
    public  $dashboardServices;
    public function __construct(DashboardServices $dashboardServices)
    {
        $this->dashboardServices = $dashboardServices;
    }


    public function index()
    {
        $response = $this->dashboardServices->index();
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);
    }

    public function fetchAllDebtorStillOwing(IndexDashboardRequest $indexDashboardRequest)
    {
        $response =  $this->dashboardServices->fetchAllDebtorStillOwing($indexDashboardRequest->validated());
        return $this->responseJson(data: $response['data'], status: $response['status'] ?? true, message: $response['message'] ?? '', responseCode: $response['statusCode']);

    }

}
