<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use App\Services\CategoryServices;
use Illuminate\Support\Facades\Validator;



class CategoryController extends Controller
{
    //use Category service
    protected $categoryServices;

    public function __construct(CategoryServices $categoryServices)
    {
        $this->categoryServices = $categoryServices;
    }

    public function index()
    {
        return $this->categoryServices->index();
    }

    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        return $this->categoryServices->storeCategory($storeCategoryRequest->all());
    }

    public function edit(EditCategoryRequest $editCategoryRequest)
    {
        return $this->categoryServices->editCategory($editCategoryRequest->all());
    }

    public function delete($id){
        return $this->categoryServices->destroy($id);
    }
}
