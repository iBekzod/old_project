<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function form()
    {
        return response()->json([
            'verification_form' => json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value)
        ], 200);
    }
}
