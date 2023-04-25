<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowSettingsRequest;
use App\Http\Requests\StoreSettingsRequest;
use App\Services\SettingServices;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    private $settingServices;

    public function __construct(SettingServices $settingServices)
    {
        $this->settingServices = $settingServices;
    }


    public function show()
    {
        return $this->settingServices->show();
    }

    public function store(StoreSettingsRequest  $storeSettingsRequest)
    {
        return $this->settingServices->store($storeSettingsRequest->all());
    }

}
