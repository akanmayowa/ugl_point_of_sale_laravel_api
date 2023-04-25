<?php

namespace App\Services;

use App\Events\InventoryReStockHistory;
use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\InventoryResource;
use Carbon\Carbon;
use App\Traits\ResponseTraits;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;


class InventoryServices
{
    use ResponseTraits;
    protected $inventories;

    public function __construct(Inventory $inventories)
    {
        $this->inventories = $inventories;
    }

    public function index(array $data)
    {
        $inventories = CheckingIdHelpers::checkAuthUserBranch($this->inventories);
        $inventories = $inventories->with('categories')->orderByDesc('id');
        if(isset($data['search']))
        {
            $search = $data['search'];
            $inventories = $this->inventories->where(function ($q) use ($search){
                                             $q->OrWhere('id', 'LIKE' ,  '%' . $search. '%' )
                                              ->OrWhere('name','LIKE' ,  '%' . $search. '%' )
                                                ->OrWhere('barcode','LIKE' ,  '%' . $search. '%' );
            });
        }
        return $this->successResponse($inventories->paginate(),"All Inventories Have Been Retrieved Successfully",200);
    }

    public function storeInventories(array $data)
    {
        $inventory = $this->inventories->create(array_merge($data,['branch_id' =>  Auth::User()->branch_id]));
        return $this->successResponse(new InventoryResource($inventory) ,"Inventory was stored successfully", 200);
    }


    public function editInventories(array $data)
    {
        try{
            $inventories = $this->inventories->firstRecord($data['id']);
            return $this->successResponse(new InventoryResource($inventories),"Successfully retrieved Inventory",200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updateInventory(array $data){
        try{
            $inventory = $this->inventories->firstRecord($data['id']);
            $inventory->update($data);
            (new StockServices())->inventoryRestockHistory($inventory, $data['quantity'], $data['price']);
            return $this->successResponse(new InventoryResource($inventory),"Inventory Was Updated Successfully", 200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id){
         CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5]);
        try{
            $this->inventories->firstRecord($id)->delete();
            return $this->successResponse(null,"Inventory was deleted successfully",200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

}
