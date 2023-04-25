<?php

namespace App\Helpers;

use App\Enums\DebtorStatusEnums;
use App\Models\Debtor;

class DebtorPaymentStatusHelpers
{

    public static function checkDebtStatus(){
        $debtor = new Debtor();
        $debtors = CheckingIdHelpers::checkAuthUserBranch($debtor);
        $debtors
                ->select('id','total_amount','status')
                ->with(['debtorDetails:id, debtor_id, initial_payment, total_amount'])
                ->withSum('debtorDetails', 'initial_payment')
                ->get()
                ->filter(static function ($items){
                    return $items['status'] === DebtorStatusEnums::Open;
                })
                ->values()
                ->filter(static function ($items){
                    return $items['total_amount'] === $items['debtor_details_sum_initial_payment'] || $items['debtor_details_sum_initial_payment'] > $items['total_amount'];
                })
                ->values()
                ->map(static function ($items){
                    $items->update(['status' => DebtorStatusEnums::Close]);
                });

        return [
            'message' => 'Debtor Status Updated successfully'
        ];
    }

}
