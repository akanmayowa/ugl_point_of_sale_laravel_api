<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\BankResource;
use App\Traits\ResponseTraits;
use App\Models\Bank;



class BankServices
{

    use ResponseTraits;

    public function index()
    {
        $banks = Bank::all()->sortByDesc('id');
        return $this->successResponse(BankResource::collection($banks),"All Banks Have Been Retrieved Successfully",202);
    }

    public function storeBank(array $data){
        try{
            if(isset($data['id'])){
                $bank = Bank::where('id', $data['id'])->first();
                $bank->update($data);
                return $this->successResponse(new BankResource($bank), 'Bank Was Updated Successfully',200);
            }
            $checkAccountNumber = Bank::where('acn_no', $data['acn_no'])->first();
            if($checkAccountNumber)
            {
                return $this->errorResponse('Account Number Already Exists', 422);
            }
            $bank = Bank::create($data);
            return $this->successResponse(new BankResource($bank),"Bank Was Added Successfully",200);
       }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function editBank(array $data)
    {
            $bank = Bank::where('id', $data['id'])->firstorFail();
            return $this->successResponse(new BankResource($bank),"Single Bank Record Successfully Retrieved",200);
    }

    public function destroy($id){
         CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5]);
        try{
            $Bank = Bank::findorFail($id);
            $Bank->delete();
            return $this->successResponse(null,"Bank was deleted successfully",200);
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

}
