<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use Illuminate\Http\Request;
use App\Services\BankServices;



class BankController extends Controller
{
    //use bank service

    protected $bankServices;
    public function __construct(BankServices $bankServices)
    {
        $this->bankServices = $bankServices;
    }

    public function index(){
        return $this->bankServices->index();
    }

    public function store(StoreBankRequest $storeBankRequest)
    {
        return $this->bankServices->storeBank($storeBankRequest->all());
    }

    public function edit(UpdateBankRequest $updateBankRequest)
    {
        return $this->bankServices->editBank($updateBankRequest->all());
    }

    public function delete($id){
        return $this->bankServices->destroy($id);
    }

}
