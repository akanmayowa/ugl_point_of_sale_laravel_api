<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\PaymentDurationResource;
use App\Models\PaymentDuration;
use App\Traits\ResponseTraits;

class PaymentDurationServices
{
    use ResponseTraits;
    protected $payment_duration;
    public function __construct(PaymentDuration $payment_duration)
    {
        $this->payment_duration = $payment_duration;
    }


    public function index()
    {
        return $this->successResponse(PaymentDurationResource::collection($this->payment_duration->all()->sortByDesc('id')),'Fetching All Payment Duration', 200);
    }

    public function store(array $data)
    {
        $payment_duration = $this->payment_duration->updateOrCreate(['duration' => $data['duration'].' month']);
        return $this->successResponse(new PaymentDurationResource($payment_duration), 'Payment Duration Added Successfully', 200);
    }

    public function delete($id)
    {
         CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5,6,7,8,9,10]);
        try{
            $payment_duration = $this->payment_duration::findorFail($id);
            $payment_duration->delete();
            return $this->successResponse(null,"Payment Duration was deleted successfully",200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }


    public function show(array $data)
    {
        $id = $data['id'];
        $payment_duration = $this->payment_duration->findOrFail($id);
        return $this->successResponse(new PaymentDurationResource($payment_duration), ' Single Payment Duration Selected', 200);
    }

}
