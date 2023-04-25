<?php
namespace App\Services;

use App\Helpers\CheckingIdHelpers;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\ResponseTraits;
use Illuminate\Support\Facades\Auth;

class  SettingServices{

    use ResponseTraits;
    protected $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    //// adjusted
    public function show()
    {
        $setting = CheckingIdHelpers::checkAuthUserBranch($this->setting)->first();
        return $this->successResponse(new SettingResource($setting), 'Fetch All Settings Successfully', 200);
    }

    public function store(array $data)
    {
        try{
            $setting = CheckingIdHelpers::checkAuthUserBranch($this->setting);
            $branchId = ['branch_id' => Auth::user()->branch_id ];
            if($setting->exists()){
                $settings = $setting->first();
                $settings->update(array_merge($data,$branchId));
            }else{
                $settings = $this->setting->create(array_merge($data,$branchId));
            }
            return $this->successResponse(new SettingResource($settings), 'Setting Added or Updated successfully', 200);
        }
        catch(\Exception $exception)
        {
            return $this->errorResponse($exception->getMessage(), 401);
        }
    }
}
