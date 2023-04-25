<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\DebtorCustomerOrderResource;
use App\Http\Resources\DebtorOrderResource;
use App\Http\Resources\DebtorResource;
use App\Http\Resources\StoreDebtorResource;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use App\Models\Order;
use App\Traits\ResponseTraits;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DebtorServices
{

    use ResponseTraits;
    protected Debtor $debtor;
    protected DebtorDetail $debtor_detail;
    protected Order $order;

    public function __construct(Debtor $debtor, DebtorDetail $debtor_detail, Order $order)
    {
        $this->debtor = $debtor;
        $this->debtor_detail = $debtor_detail;
        $this->order = $order;
    }

    public function index(array $data)
    {
        $debtor = CheckingIdHelpers::checkAuthUserBranch($this->debtor);
        $debtor = $debtor->select('id','user_id','debtor_number','order_id','order_number','customer_id','total_amount','discount','status','payment_duration', 'created_at')
                                  ->with('debtorDetails:id,initial_payment,debtor_id,total_amount,discount,payment_date,created_at')
                                  ->with('customer:id,name,email')
                                  ->with('order:id,order_number')
                                  ->with('employee:id,first_name,last_name,staff_id');

        if(isset($data['search']))
        {
            $search = $data['search'];
            $debtor = $debtor->where( function($query) use ($search){
                                                     $query->orWhere('id', 'LIKE', '%' .  $search . '%')
                                                    ->orWhere('customer_id', 'LIKE', '%' . $search . '%')
                                                    ->orWhere('debtor_number', 'LIKE', '%' . $search . '%')
                                                    ->orWhere('order_id', 'LIKE', '%' .  $search . '%')
                                                    ->orWhere('order_number', 'LIKE', '%' . $search . '%');
                                });
        }

        return $this->successResponse($debtor->orderByDesc('id')->paginate(10),'All Debtors Selected SuccessFully',200);
    }

    public function getOrder($orderNumber)
    {
        return $this->order->where('branch_id', Auth::user()->branch_id)->where('order_number', $orderNumber)->first();
    }

    public function store(array $data)
    {
       try {
           $data['user_id'] = auth()->user()->id;
           $data['debtor_number'] =  (new \App\Helpers\GenerateRandomNumber)->uniqueRandomNumber('UGL-DBT-', 10);
           $data['total_amount'] = $this->getOrder($data['order_number'])->total;
           $orderId = ['order_id' => $this->getOrder($data['order_number'])->id];
           $data['branch_id'] = auth()->user()->branch_id;
            $debtor = $this->debtor->create(array_merge($data, $orderId));

            if (isset($data['initial_payment'])) {
                $debtPaymentData = [
                    'user_id' => $data['user_id'],
                    'debtor_id' => $debtor->id,
                    'debtor_number' => $data['debtor_number'],
                    'initial_payment' => $data['initial_payment'],
                    'total_amount' => $data['total_amount'],
                    'discount' => $data['discount'] ?? 0,
                    'branch_id' => $data['branch_id'],
                    'payment_duration' => $data['payment_duration'] ?? Carbon::now()->format('Y-m-d'),
                    'payment_date' => $data['payment_date'] ?? Carbon::now()->format('Y-m-d'),
                ];
                $this->debtor_detail->create($debtPaymentData);
            }
            return $this->successResponse(new StoreDebtorResource($debtor), 'Debtor Created Successfully', 200);
      }
      catch(Exception $exception){
          return $exception->getMessage();
      }


    }

    public function show(array $data)
    {
        $debtor = $this->debtor->where('id', $data['id'])->first();
        if(empty($debtor))
        {
            return $this->errorResponse('Debtor Record Not Found', 401);
        }
        return $this->successResponse(new DebtorResource($debtor),'Show Single Debtor',200);
    }

    public function delete($id)
    {

        try
        {
            $debtor = $this->debtor->where('id', $id)->first();
            if(!$debtor)
            {
                return $this->errorResponse('Debtor ID Not Found', 422);
            }
            $debtor->delete();
            return $this->successResponse(null,'Debtor Deleted Successfully',200);
        }
        catch(\Exception $exception)
        {
                return $exception;
        }
    }

    public function customerDebtPayment (array $data)
        {
            $debtorDetailData = [
                'debtor_id' => $data['debtor_id'],
                'debtor_number' => $data['debtor_number'],
                'initial_payment' => $data['initial_payment'],
                'total_amount' => $data['total_amount'],
                'user_id' => auth()->user()->id,
                'discount' =>  $data['discount'] ?? 0,
                'branch_id' => Auth::user()->branch_id,
                'payment_date' => $data['payment_date'] ?? Carbon::now()->format('Y-m-d'),
            ];

            $debtor_details = $this->debtor_detail->create($debtorDetailData);
            return $this->successResponse($debtor_details,'Debtor Details Created Successfully', 200);
        }

    public function fetchAllOrders(array $data)
    {

        $customerId = $data['customer_id'];
        $getAllOrder = CheckingIdHelpers::checkAuthUserBranch($this->order);
        $getAllOrder = $getAllOrder->where('branch_id', Auth::user()->branch_id)->select('id', 'order_number', 'customer_id')
                                    ->with('customer:id,name,email')
                                    ->whereHas('customer', function(Builder $query) use ($customerId) {
                                        $query->where('id', $customerId);
                                    })->get();
        return $this->successResponse(DebtorCustomerOrderResource::collection($getAllOrder), 'Customer Orders Retrieved SuccessFully', 200);
    }

}
