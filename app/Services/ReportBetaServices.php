<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Models\BusinessSegment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\TransactionMode;

class ReportBetaServices
{

    public function __construct(protected Transaction $transaction,
                                protected TransactionMode $transactionMode,
                                protected BusinessSegment $businessSegment,
                                protected Order $order,
                                protected OrderDetail $orderDetail){

    }

    public function relationshipFilter($filterValue, $item): \Closure
    {
        return  static function ($query) use ($filterValue, $item){
            $query->where($filterValue, $item);
        };
    }

    public function salesTypeReport(array $data): array
    {
        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;
        $sales_type = $data['transaction_mode_id'] ?? null;

        $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction)
                                        ->select('id', 'reference_number', 'order_id', 'customer_id', 'transaction_mode_id', 'transaction_date', 'amount', 'user_id','branch_id')
                                        ->with(['user:id,staff_id,first_name,last_name'])
                                        ->with('orders:id,order_number')
                                        ->with('customer:id,name')
                                        ->with('transactionMode:id,transaction_mode')
                                        ->orderByDesc('transaction_date')
                                        ->orderByDesc('id')
                                        ->when($sales_type, function ($query) use ($sales_type) {
                                            $query->where('transaction_mode_id', $sales_type);
                                        })
                                        ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                                            $query->whereBetween('transaction_date', [$start_date, $end_date]);
                                        })
                                        ->when($start_date && $end_date && $sales_type, function ($query) use ($sales_type, $start_date, $end_date) {
                                            $query->where('transaction_mode_id',  $sales_type)
                                                   ->whereBetween('transaction_date', [$start_date, $end_date]);
                                        })->paginate(10);
            return [
                'data' => $transaction,
                'message' => 'All Transaction Successfully Selected',
                'status' => true,
                'statusCode' => 200,
            ];
    }

    public function businessSegmentReport($data = []): array
    {

        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;
        $business_segment = $data['business_segment_id'] ?? null;
        $filter =  $this->relationshipFilter('business_segment_id',  $business_segment);

        $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction)
                                        ->select('id', 'reference_number', 'order_id', 'customer_id', 'transaction_mode_id', 'transaction_date', 'amount', 'user_id','branch_id')
                                        ->with(['user:id,staff_id,first_name,last_name'])
                                        ->with('orders:id,order_number')
                                        ->with(['customer:id,name,business_segment_id', 'customer.businessSegment:id,name'])
                                        ->with('transactionMode:id,transaction_mode')
                                        ->orderByDesc('transaction_date')
                                        ->orderByDesc('id')
                                        ->when($start_date && $end_date && $business_segment, function ($query) use ($start_date, $end_date, $filter) {
                                        $query->whereHas( 'customer', $filter)
                                                ->whereBetween('transaction_date', [$start_date, $end_date]);
                                        })
                                        ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                                            $query->whereBetween('transaction_date', [$start_date, $end_date]);
                                        })
                                        ->when($business_segment, function ($query) use ($filter) {
                                            $query->whereHas( 'customer', $filter);
                                        })->paginate(10);

        return [
            'data' => $transaction,
            'message' => 'All Transaction And Business Segment Record Successfully Selected',
            'status' => true,
            'statusCode' => 200,
        ];
    }

    public function customerTypeReport(array $data) :array {

        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;
        $customer_type = $data['customer_type_id'] ?? null;
        $filter = $this->relationshipFilter('customer_type_id', $customer_type);

        $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction)
                            ->select('id', 'reference_number', 'order_id', 'customer_id', 'transaction_mode_id', 'transaction_date', 'amount', 'user_id','branch_id')
                            ->with(['user:id,staff_id,first_name,last_name'])
                            ->with('orders:id,order_number')
                            ->with(['customer:id,name,customer_type_id', 'customer.customerType:id,types'])
                            ->with('transactionMode:id,transaction_mode')
                            ->orderByDesc('transaction_date')
                            ->orderByDesc('id')
                            ->when($start_date && $end_date && $customer_type, function ($query) use ($start_date, $end_date, $filter) {
                                $query->whereHas( 'customer', $filter)
                                    ->whereBetween('transaction_date', [$start_date, $end_date]);
                            })
                            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date, ) {
                                $query->whereBetween('transaction_date', [$start_date, $end_date]);
                            })
                            ->when($customer_type, function ($query) use ($filter) {
                                $query->whereHas( 'customer', $filter);
                            })->paginate(10);

        return [
            'data' => $transaction,
            'message' => 'All Transaction And Business Segment Record Successfully Selected',
            'status' => true,
            'statusCode' => 200,
        ];

    }

    public function InventoryOrProductTypeReport(array $data) : array
    {
        $start_date = $data['start_date'] ?? null;
        $end_date = $data['end_date'] ?? null;
        $inventory = $data['inventory_id'] ?? null;
        $inventoryReport = $this->orderDetail->select('order_id','inventory_id','quantity','price','created_at')
                                            ->with(['inventory:id,name','order:id,order_number,customer_id', 'order.customer:id,name'])
                                            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                                                $query->whereBetween('created_at', [$start_date, $end_date]);
                                            })
                                            ->when($start_date && $end_date && $inventory, function ($query) use ($start_date, $end_date, $inventory) {
                                                $query->whereBetween('created_at', [$start_date, $end_date])->where('inventory_id', $inventory);
                                            })
                                            ->when($inventory, function ($query) use ($inventory) {
                                                $query->where('inventory_id', $inventory);
                                            })->paginate(10);

        return [
            'status' => true,
            'message' => 'Cashier Daily Report Successfully Retrieved',
            'statusCode' => 200,
            'data' => $inventoryReport
        ];
    }

}
