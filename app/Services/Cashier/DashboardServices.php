<?php

namespace App\Services\Cashier;

use App\Helpers\CheckingIdHelpers;
use App\Models\Customer;
use App\Models\Debtor;
use App\Models\Transaction;

class DashboardServices
{
    protected  $customer;
    protected  $transaction;
    protected  $debtor;

    public function __construct(Customer $customer, Transaction $transaction, Debtor $debtor)
    {
        $this->customer = $customer;
        $this->transaction = $transaction;
        $this->debtor = $debtor;
    }


    public function index()
    {
        $authUser = auth()->user();
        $cashierCounter = [
            'nos_of_customer' => $this->customer->count(),
            'total_transaction' => CheckingIdHelpers::checkAuthUserBranch($this->transaction)->where('user_id', $authUser->id)->sum('amount'),
            'total_pos_transaction' => CheckingIdHelpers::checkAuthUserBranch($this->transaction)->where('user_id', $authUser->id)->where('transaction_mode_id', 1)->sum('amount'),
            'total_cash_transaction' => CheckingIdHelpers::checkAuthUserBranch($this->transaction)->where('user_id', $authUser->id)->where('transaction_mode_id', 2)->sum('amount'),
            'total_transfer_transaction' => CheckingIdHelpers::checkAuthUserBranch($this->transaction)->where('user_id', $authUser->id)->where('transaction_mode_id', 3)->sum('amount'),
            'total_pay_later' => CheckingIdHelpers::checkAuthUserBranch($this->transaction)->where('user_id', $authUser->id)->where('transaction_mode_id', 4)->sum('amount'),
            'nos_of_owing_debtor' => $this->counterForOwingDebtor(),
        ];

          return [
          'statusCode' => 200,
          'data' => $cashierCounter,
          'status' => true,
          'message' => 'Cashier DashBoard Selected Successfully'
        ];

}


    public function checkIfDebtorBranchIdExist(){
     $authUser = auth()->user();
     return  CheckingIdHelpers::checkAuthUserBranch($this->debtor)->where('user_id', $authUser->id);
   }

    public function fetchAllDebtorStillOwing(array $data)
    {
        $search = $data['search'] ?? null;
        $debtors = $this->checkIfDebtorBranchIdExist()
                                    ->select('id','debtor_number', 'order_number','customer_id','payment_duration','total_amount', 'branch_id',  'user_id')
                                    ->when($search, function ($query) use ($search) {
                                        $query->whereDate('created_at', $search);
                                    })
                                    ->with(['debtorDetails:id,debtor_id,debtor_number,initial_payment,total_amount,discount,payment_date'])
                                    ->with(['customer:id,name,email'])
                                    ->with(['employee:id,first_name,last_name,staff_id'])
                                    ->withSum('debtorDetails', 'initial_payment')
                                    ->get()
                                    ->filter(static function ($items){
                                        return $items['total_amount'] > $items['debtor_details_sum_initial_payment'] || $items['debtor_details_sum_initial_payment'] === null;
                                    })->values();

        return [
            'message' => 'All Still Owing Debtors selected Successfully',
            'data' => $debtors,
            'status' => true,
            'statusCode' => 200,
        ];
    }

    public function counterForOwingDebtor()
    {
        return $this->checkIfDebtorBranchIdExist()->select('id', 'total_amount', 'user_id')
            ->with('debtorDetails')
            ->withSum('debtorDetails', 'initial_payment')
            ->get()
            ->filter( function ($items) {
                return $items['total_amount'] > $items['debtor_details_sum_initial_payment'] || $items['debtor_details_sum_initial_payment'] === null;
            })
            ->count();

    }



}
