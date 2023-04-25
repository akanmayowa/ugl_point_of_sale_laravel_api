<?php

namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\ResponseTraits;
use App\Models\Category;



class CategoryServices
{

    use ResponseTraits;
    protected $categories;

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        $categories = $this->categories::select('id', 'name', 'created_at')->orderByDesc('id')->get();
        return $this->successResponse($categories,"All Categories Have Been Retrieved Successfully",200);
    }

    public function storeCategory(array $data)
    {
        try{
            if(isset($data['id']))
            {
                $category = $this->categories::updateOrCreate(['id'=>$data['id']],['name' => $data['name']]);
                return $this->successResponse(new CategoryResource($category),'Category Was Added Successfully',200);
            }

            $category = $this->categories->where('name', $data['name'])->first();
            if($category)
            {
                return $this->errorResponse('Category Name Already ', 401);
            }

            $category = $this->categories::create($data);
            return $this->successResponse(new CategoryResource($category),"Category was added successfully",200);
        }

       catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function editCategory(array $data){
        try{
            $category = Category::where('id', $data['id'])->first();
            if(!$category){
                return $this->errorResponse("Category not found");
            }
            return $this->successResponse(new CategoryResource($category),'Single Category Successfully retrieved Category',200);
        }catch(\Exception $e)
        {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function destroy($id)
    {
       CheckingIdHelpers::preventIdDeletion((int)$id, [1,2,3,4,5]);
        try{
            $Category = Category::findorFail($id);
            $Category->delete();
            return $this->successResponse(null,'Category was deleted successfully',200);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }




}
