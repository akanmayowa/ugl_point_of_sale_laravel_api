<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\BranchResource;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\ResponseTraits;
use App\Models\Branch;



class BranchServices
{

    use ResponseTraits;
    public function index(array $data)
    {
        $branch = Branch::query();
        if(isset($data['name']))
        {
            $search = $data['name'];
            $branch = $branch->where('name', 'like', '%' . $search  . '%');
        }
        return $this->successResponse($branch->orderByDesc('id')->get(),"All Branch Have Been Retrieved Successfully",200);
    }

    public function storeBranch(array $data){
        try{
            $branch = Branch::updateOrCreate([
                'id'   => $data["id"] ?? null,
            ],[
                'name' => $data["name"],
                'address' => $data["address"],
                'phone_no' => $data["phone_no"],
                'email' => $data["email"]
            ]);
            return $this->successResponse(new BranchResource($branch),"Branch was added successfully",200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }

    }

    public function editBranch(array $data)
    {
            $branch = Branch::where('id', $data['id'])->firstOrFail();
            return $this->successResponse(new BranchResource($branch),"Single Branch Successfully retrieved",200);
    }

    public function destroy($id){
         CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5]);
        try{
            $branch = Branch::findorFail($id);
            $branch->delete();
            return $this->successResponse(null,"Branch was deleted successfully",200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }


}
