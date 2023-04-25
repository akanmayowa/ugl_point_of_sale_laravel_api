<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditBranchRequest;
use App\Http\Requests\IndexBranchRequest;
use App\Http\Requests\StoreBranchRequest;
use Illuminate\Http\Request;
use App\Services\BranchServices;

class BranchController extends Controller
{
    protected $branchServices;
    public function __construct(BranchServices $branchServices)
    {
        $this->branchServices = $branchServices;
    }

    public function index(IndexBranchRequest $indexBranchRequest){
        return $this->branchServices->index($indexBranchRequest->all());
    }

    public function store(StoreBranchRequest $storeBranchRequest){
        return $this->branchServices->storeBranch($storeBranchRequest->all());
    }

    public function edit(EditBranchRequest $editBranchRequest){
        return $this->branchServices->editBranch($editBranchRequest->all());
    }

    public function delete($id){
        return $this->branchServices->destroy($id);
    }
}
