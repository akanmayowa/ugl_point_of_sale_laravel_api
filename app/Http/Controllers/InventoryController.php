<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexInventoryRequest;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\InventoryServices;

class InventoryController extends Controller
{
    //use inventory service

    protected $inventoryServices;

    public function __construct(InventoryServices $inventoryServices)
    {
        $this->inventoryServices = $inventoryServices;
    }

    public function index(IndexInventoryRequest $indexInventoryRequest): JsonResponse
    {
        return $this->inventoryServices->index($indexInventoryRequest->validated());
    }

    public function store(StoreInventoryRequest $storeInventoryRequest): JsonResponse
    {
        return $this->inventoryServices->storeInventories($storeInventoryRequest->validated());
    }

    public function edit(Request $request): JsonResponse
    {
        return $this->inventoryServices->editInventories($request->all());
    }

    public function update(UpdateInventoryRequest $updateInventoryRequest): JsonResponse
    {
        return $this->inventoryServices->updateInventory($updateInventoryRequest->validated());
    }

    public function delete($id): JsonResponse
    {
        return $this->inventoryServices->destroy($id);
    }
}
