<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowTransactionModeRequest;
use App\Http\Requests\StoreTransactionModeRequest;
use App\Services\TransactionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionModeController extends Controller
{
    protected $transactionServices;
    public function __construct(TransactionServices $transactionServices)
    {
        $this->transactionServices = $transactionServices;
    }


    public function index() : JsonResponse
    {
        return $this->transactionServices->index();
    }


    public function store(StoreTransactionModeRequest $storeTransactionModeRequest) : JsonResponse
    {
        return $this->transactionServices->storeOrUpdate($storeTransactionModeRequest->all());
    }

    public function show(ShowTransactionModeRequest $showTransactionModeRequest) : JsonResponse
    {
        return $this->transactionServices->show($showTransactionModeRequest->all());
    }

    public function delete($id)
    {
        return $this->transactionServices->delete($id);
    }

}
