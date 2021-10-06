<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BusinessSettingCollection;
use App\BusinessSetting;
use App\Http\Controllers\Controller;


class BusinessSettingController extends Controller
{
    public function index()
    {
        return new BusinessSettingCollection(BusinessSetting::all());
    }
}
