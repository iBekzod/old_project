<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\BusinessSetting;
use App\ClubPointDetail;
use App\ClubPoint;
use App\Http\Resources\ClubPointCollection;
use App\Product;
use App\Wallet;
use App\Order;
use Auth;

class ClubPointController extends Controller
{
    public function userpoint_index()
    {
        $club_points = ClubPoint::where('user_id', auth()->id())->latest()->paginate(15);
        return new ClubPointCollection($club_points);
    }

    public function club_point_detail($club_point_id)
    {
        $club_points = ClubPoint::where('user_id', auth()->id())->where('id', $club_point_id)->latest()->paginate(15);
        return new ClubPointCollection($club_points);
    }

    public function convert_point_into_wallet(Request $request)
    {
        $club_point_convert_rate = BusinessSetting::where('type', 'club_point_convert_rate')->first()->value;
        $club_point = ClubPoint::findOrFail($request->id);
        $wallet = new Wallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->amount = floatval($club_point->points / $club_point_convert_rate);
        $wallet->payment_method = 'Club Point Convert';
        $wallet->payment_details = 'Club Point Convert';
        $wallet->save();
        $user = Auth::user();
        $user->balance = $user->balance + floatval($club_point->points / $club_point_convert_rate);
        $user->save();
        $club_point->convert_status = 1;
        if ($club_point->save()) {
            return response()->json([
                'data'=>$wallet,
                'status'=>true,
                'message' =>translate("Refund Request has been sent successfully")
           ]);
        }
        else {
            return response()->json([
                'data'=>[],
                'status'=>false,
                'message' =>translate("Rejected request")
            ]);
        }
    }
}
