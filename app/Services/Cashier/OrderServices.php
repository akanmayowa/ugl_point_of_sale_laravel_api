<?php

namespace App\Services\Cashier;


use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\DebtorCustomerOrderResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderServices
{

    public function __construct(protected Order $order)
    {
    }

    public function index($data = [])
    {
        $authUser = auth()->user();
        $orders = CheckingIdHelpers::checkAuthUserBranch($this->order);
        $orders = $orders->select('id', 'order_number','customer_id','subtotal','total','discount',
                                                         'loyalty_discount', 'staff_id', 'order_date','created_at','user_id')
                                        ->with('customer:id,name', 'employee:id,first_name,last_name')
                                        ->where('user_id', $authUser->id);

        if (isset($data['order_number']))
        {
            $orders = $orders->where('order_number', 'like', '%' . $data['order_number'] . '%')->orderByDesc('id');
        }

        $orders = $orders->orderByDesc('id')->paginate(10);
        return [
            'message' => 'All Orders Selected Successfully',
            'status' => true,
            'statusCode' => 200,
            'data' => $orders
        ];
    }

}
