<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SettingsCollection;
use App\AppSettings;

class SettingsController extends Controller
{
    public function index()
    {
        return new SettingsCollection(AppSettings::all());
    }
}
