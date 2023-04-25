<?php

namespace App\Helpers;

use App\Traits\ResponseTraits;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class CheckingIdHelpers
{
    use ResponseTraits;
    public static function preventIdDeletion(int $deleteId , array $ArrayIdList): bool
    {
        $checkIdExist = in_array($deleteId, $ArrayIdList, false);
        if($checkIdExist){
            abort(401, 'Record Cant Be Deleted' );
        }
    }

    public static function checkAuthUserBranch($model)
    {
        $authUserBranch = Auth::user()->branch_id ?? null;
        if($authUserBranch === null)
        {
            throw new  RuntimeException('A Branch is Required');
        }
        return $model::where('branch_id', $authUserBranch);
    }
}
