<?php

namespace App\Services\Cashier;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\DebtorCustomerOrderResource;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class DebtorServices
{

    protected  $debtor;
    protected  $debtor_detail;
    protected $order;

    public function __construct(Debtor $debtor, DebtorDetail $debtor_detail, Order $order)
    {
        $this->debtor = $debtor;
        $this->debtor_detail = $debtor_detail;
        $this->order = $order;

    }


    public function index(array $data)
    {
        $authUserId = auth()->user()->id;
        $debtor = CheckingIdHelpers::checkAuthUserBranch($this->debtor);
        $debtor = $debtor->where('user_id', $authUserId)
                        ->select('id','user_id','debtor_number','order_id','order_number','customer_id','total_amount','discount','status','payment_duration', 'created_at')
                        ->with('debtorDetails:id,initial_payment,debtor_id,total_amount,discount,payment_date,created_at')
                        ->with('customer:id,name,email')
                        ->with('order:id,order_number')
                        ->with('employee:id,first_name,last_name,staff_id');

        if(isset($data['search']))
        {
            $search = $data['search'];
            $this->debtor->where( function($query) use ($search){
                        $query->orWhere('id', 'LIKE', '%' .  $search . '%')
                        ->orWhere('customer_id', 'LIKE', '%' . $search . '%')
                        ->orWhere('debtor_number', 'LIKE', '%' . $search . '%')
                        ->orWhere('order_id', 'LIKE', '%' .  $search . '%')
                        ->orWhere('order_number', 'LIKE', '%' . $search . '%');
            });
        }

        return [
            'data' =>  $debtor->orderByDesc('id')->paginate(10),
            'message' =>  'All Debtors Selected SuccessFully',
            'status' =>   true,
            'statusCode' => 200,
        ];
    }


    public function fetchAllCustomerOrders(array $data)
    {

        $authUserId = auth()->user()->id;
        $customerId = $data['customer_id'];
        $getAllOrder = CheckingIdHelpers::checkAuthUserBranch($this->order);
        $getAllOrder = $getAllOrder->select('id', 'order_number', 'customer_id')
                                    ->where('user_id', $authUserId)
                                    ->with('customer:id,name,email')
                                    ->whereHas('customer', function(Builder $query) use ($customerId) {
                                        $query->where('id', $customerId);
                                    })->get();

        return [
            'data' => DebtorCustomerOrderResource::collection($getAllOrder),
            'message' => 'Customer Orders Retrieved SuccessFully',
            'statusCode' => 200
      ];
    }

}
