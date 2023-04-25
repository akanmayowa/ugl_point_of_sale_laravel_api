<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\TransactionModeResource;
use App\Models\TransactionMode;
use App\Traits\ResponseTraits;
use Exception;

class TransactionServices
{
    use ResponseTraits;
    protected $transactionMode;

    public function __construct(TransactionMode $transactionMode){
        $this->transactionMode = $transactionMode;
    }

    public function index()
    {
        return $this->successResponse(TransactionModeResource::collection($this->transactionMode->all()->sortByDesc('id', )), 'All Payment Mode Successfully',200);
    }

    public function storeOrUpdate(array $data)
    {

        try{
        if(isset($data['id'])){
            $transaction_mode = $this->transactionMode->where('id', $data['id'])->first();
            $transaction_mode->update($data);
            return $this->successResponse(new TransactionModeResource($transaction_mode), 'Transaction Mode Updated Successfully',200);
        }

        $transaction_mode = $this->transactionMode->updateOrCreate([
            'transaction_mode' => $data['transaction_mode']
        ]);
        return $this->successResponse(new TransactionModeResource($transaction_mode), 'Transaction Mode Added Successfully',200);
        }
        catch(Exception $exception)
        {
                return $exception->getMessage();
        }

    }

    public function delete($id)
    {
        $checkId = CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5]);
        if($checkId){
            return $this->errorResponse( 'Record Cant Be Deleted', 401);
        }
            try{
                 $this->transactionMode->where('id', $id)->firstOrFail()->delete();
                return $this->successResponse(null, 'Transaction Mode Deleted Successfully', 200);
            }
            catch(Exception $exception)
            {
                    return $exception->getMessage();
            }

        }

    public function show(array $data)
    {
        return $this->successResponse(new TransactionModeResource($this->transactionMode->findOrFail($data['id'])), 'Single Payment Mode Selected', 200);
    }

}
