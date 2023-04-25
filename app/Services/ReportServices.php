<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Helpers\CollectionPagination;
use App\Http\Resources\ReportTransactionResource;
use App\Models\Debtor;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\ResponseTraits;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportServices
{
    use ResponseTraits;
    protected Transaction $transaction;
    protected User $user;
    protected Debtor $debtor;
    protected Order $order;

    public function __construct(Transaction  $transaction, User $user, Debtor $debtor, Order $order)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->debtor = $debtor;
        $this->order = $order;
    }

     public function dailyReport(array $data)
    {
        $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction);
        $transaction = $transaction->select('id', 'reference_number', 'staff_id', 'order_id', 'customer_id', 'transaction_mode_id', 'transaction_date', 'amount', 'user_id','branch_id', 'created_at')
                                            ->with(['user:id,staff_id,first_name,last_name','transactionMode:id,transaction_mode','customer:id,name,email,phone_number', 'orders:id,order_number'])
                                             ->orderByDesc('created_at')
                                             ->orderByDesc('id');

        if(isset($data['start_date'], $data['end_date']))
        {
            $transaction = $transaction->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
        }

         $records = $transaction->paginate(10);
        return $this->successResponse($records, 'All Transaction Successfully Selected', 200);
    }

     public function transactionReport(array $data)
     {
        $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction);
        $transaction = $transaction
                                    ->selectRaw("transaction_date as TRANSACTION_DATE, SUM(amount) as TOTAL_AMOUNT")
                                    ->selectRaw("SUM(case when transaction_mode_id = 1 then amount else 0 end) as POS")
                                    ->selectRaw("SUM(case when transaction_mode_id = 2 then amount else 0 end) as CASH")
                                    ->selectRaw("SUM(case when transaction_mode_id = 3 then amount else 0 end) as BANK_TRANSFER")
                                    ->selectRaw("SUM(case when transaction_mode_id = 4 then amount else 0 end) as PAY_LATER")
                                    ->orderByDesc('id')
                                    ->orderByDesc('transaction_date')
                                    ->groupBy(DB::raw('Date(transaction_date)'));



        if(isset($data['start_date'], $data['end_date']))
        {
            $transaction = $transaction->whereBetween('transaction_date', [$data['start_date'], $data['end_date']]);
        }
        else {
            $transaction = $transaction;
        }

        return $this->successResponse($transaction->paginate(10),'Fetch All User Transactions', 200);

    }

       public function cashierReport(array $data)
        {
            $transaction = CheckingIdHelpers::checkAuthUserBranch($this->transaction);
            $transaction = $transaction->select('id', 'transaction_date', 'user_id', 'branch_id')
                                                ->selectRaw('sum(amount) as cashier_total_sales')
                                                ->with(['user:id,staff_id,first_name,last_name'])
                                                 ->with('orders:id,order_number')
                                                ->orderByDesc('transaction_date')
                                                ->groupBy('user_id');

            if(isset($data['start_date'], $data['end_date'], $data['user_id']))
            {
                $transaction = $transaction->whereBetween('transaction_date', [$data['start_date'], $data['end_date']])
                                                ->where('user_id', $data['user_id'])
                                                ->get()
                                                ->map(function($transaction) use ($data){
                                                    $transaction['start_date'] = $data['start_date'] ?? Carbon::createFromFormat('Y-m-d H:i:s',  $transaction['transaction_date']);
                                                    $transaction['end_date'] = $data['end_date'] ?? Carbon::now();
                                                    return $transaction;
                                                });

            }

            else if(isset($data['start_date'], $data['end_date']))
            {
                        $transaction = $transaction->whereBetween('transaction_date', [$data['start_date'], $data['end_date']])->paginate(10);
                        $transaction = $this->mapCashierSales($transaction,$data);
            }

            else if(isset($data['user_id']))
            {
                        $transaction = $transaction->where('user_id', $data['user_id'])->paginate(10);
                        $transaction = $this->mapCashierSales($transaction,$data);
            }

            else
            {
                $transaction =  $transaction->paginate(10);
                $transaction =  $this->mapCashierSales($transaction,$data);
            }

            return $this->successResponse($transaction,'Cashier Sales Record Retrieved Successfully', 200);
        }

      public function debtorReport(array $data)
       {
           $customer_debtor_record = CheckingIdHelpers::checkAuthUserBranch($this->debtor);
           $customer_debtor_record = $customer_debtor_record->select('id', 'debtor_number', 'order_number', 'total_amount', 'customer_id', 'discount', 'payment_duration' , 'branch_id' ,'user_id', 'created_at')
                                            ->with(['employee:id,staff_id,first_name,last_name'])
                                            ->with(['customer:id,name,email,phone_number,gender'])
                                            ->orderByDesc('id');

            if(isset($data['start_date'], $data['end_date'], $data['customer_id']))
            {
                $customer_debtor_record = $customer_debtor_record->where('customer_id', $data['customer_id'])
                                                                    ->whereBetween('created_at', [$data['start_date'], $data['end_date']]);

            }

            elseif (isset($data['customer_id']))
            {
                $customer_debtor_record = $customer_debtor_record->where('customer_id', $data['customer_id']);
            }

            elseif(isset($data['start_date'], $data['end_date']))
            {
                $customer_debtor_record = $customer_debtor_record->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
            }

            return [
                'message' => 'Debtor Record Successfully Retrieved',
                'data' => $customer_debtor_record->paginate(10),
                'status' => true,
                'statusCode' => 200,
              ];
    }

        public function mapCashierSales($transaction,$data)
        {
            return $transaction->through(function($transaction) use ($data){
                $transaction['start_date'] = $data['start_date'] ?? Carbon::createFromFormat('Y-m-d H:i:s',  $transaction['transaction_date']);
                $transaction['end_date'] = $data['end_date'] ?? Carbon::now();
                return $transaction;
            });
        }

        public function fetchAllUser(array $data)
        {
            $data['limit'] = $data['limit'] ?? 0;
            $user = CheckingIdHelpers::checkAuthUserBranch($this->user);
            $user = $user->select('id', 'first_name', 'last_name', 'branch_id');
            if(isset($data['search'])){
                $search = $data['search'];
              $user = $user->where(function($query) use ($search){
                              $query->OrWhere('id',  'like', '%'.$search.'%');
                              $query->OrWhere('first_name',  'like', '%'.$search.'%');
                              $query->OrWhere('last_name',  'like', '%'.$search.'%');
                              $query->orWhere(DB::raw("CONCAT(`first_name`,' ',`last_name`)"), 'like', '%' . $search . '%');
                          });
            }
             $user = $user->paginate($data['limit']);

            return [
                'status' => true,
                'statusCode' => 200,
                'message' => 'Fetch All User',
                'data' => $user,
            ];
        }

        public function cashierDailyReport(array $data)
        {
            $cashier_daily_report = CheckingIdHelpers::checkAuthUserBranch($this->transaction);
            $cashier_daily_report = $cashier_daily_report->select('id', 'reference_number', 'transaction_date', 'user_id','amount','order_id', 'branch_id' )
                                                    ->with(['user:id,staff_id,first_name,last_name'])
                                                    ->with('orders:id,order_number')
                                                    ->orderByDesc('transaction_date');

            if(isset($data['start_date'], $data['end_date'], $data['user_id']))
            {
                $cashier_daily_report = $cashier_daily_report->whereBetween('transaction_date', [$data['start_date'], $data['end_date']])
                                                            ->where('user_id', $data['user_id']);

            }

            else if(isset($data['start_date'], $data['end_date']))
            {
                $cashier_daily_report = $cashier_daily_report->whereBetween('transaction_date', [$data['start_date'], $data['end_date']]);
            }

            else if(isset($data['user_id']))
            {
                $cashier_daily_report = $cashier_daily_report->where('user_id', $data['user_id']);
            }

            return [
                'status' => true,
                'message' => 'Cashier Daily Report Successfully Retrieved',
                'statusCode' => 200,
                'data' => $cashier_daily_report->paginate(10)
            ];

        }

        public function orderDetailReport(array $data)
        {
            $customer = isset($data['customer_id']) ? $data['customer_id'] : null;
            $start_date = isset($data['start_date']) ? $data['start_date'] : null;
            $end_date = isset($data['end_date']) ? $data['end_date'] : null;

            $orderDetailsReport = CheckingIdHelpers::checkAuthUserBranch($this->order)
                                                ->select('id', 'order_number', 'customer_id', 'total' , 'order_date')
                                                ->with('customer:id,name')
                                                ->with(['orderDetail:order_id,inventory_id,quantity,price,amount,branch_id', 'orderDetail.inventory:id,name'])
                                                ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                                                    $query->whereBetween('order_date', [$start_date, $end_date]);
                                                })
                                                ->when($start_date && $end_date && $customer, function ($query) use ($start_date, $end_date, $customer) {
                                                    $query->whereBetween('order_date', [$start_date, $end_date])
                                                            ->where('customer_id', $customer);
                                                })
                                                ->when($customer, function ($query) use ($data) {
                                                       $query->where('customer_id', $data['customer_id']);
                                                })
                                                ->paginate(10);
            return [
                'status' => true,
                'message' => 'Cashier Daily Report Successfully Retrieved',
                'statusCode' => 200,
                'data' => $orderDetailsReport
            ];

        }

}
