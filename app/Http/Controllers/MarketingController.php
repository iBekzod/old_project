<?php

namespace App\Http\Controllers;

use App\FlashDeal;
use App\FlashDealProduct;
use App\FlashDealTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MarketingController extends Controller
{
    public function updateStatus(Request $request)
    {
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->status = $request->status;
        if($flash_deal->save()){
            flash(translate('Flash deal status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function edit(Request $request, $id)
    {
        $flashDeal = FlashDeal::findOrFail($id);

        return view('frontend.marketing.edit', [
            'flash_deal' => $flashDeal,
            'lang' => $request->get('lang')
        ]);
    }

    public function updateFeatured(Request $request)
    {
        foreach (FlashDeal::all() as $key => $flash_deal) {
            $flash_deal->featured = 0;
            $flash_deal->save();
        }
        $flash_deal = FlashDeal::findOrFail($request->id);
        $flash_deal->featured = $request->featured;
        if($flash_deal->save()){
            flash(translate('Flash deal status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function marketing()
    {
        $flash_deals = FlashDeal::where('user_id', Auth::user()->id)->latest()->paginate(10);

        return view('frontend.marketing.index', [
            'flash_deals' => $flash_deals
        ]);
    }

    public function create()
    {
        return view('frontend.marketing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'background_color' => 'required',
            'text_color' => 'required',
            'banner' => 'required',
            'date_range' => 'required',
            'products' => 'required',
        ]);

        $flash_deal = new FlashDeal;
        $flash_deal->user_id = Auth::user()->id;
        $flash_deal->title = $request->title;
        $flash_deal->text_color = $request->text_color;

        $date_var               = explode(" to ", $request->date_range);
        $flash_deal->start_date = strtotime($date_var[0]);
        $flash_deal->end_date   = strtotime( $date_var[1]);

        $flash_deal->background_color = $request->background_color;
        $flash_deal->slug = strtolower(str_replace(' ', '-', $request->title).'-'.Str::random(5));
        $flash_deal->banner = $request->banner;
        if($flash_deal->save()){
            foreach ($request->products as $key => $product) {
                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $product;
                $flash_deal_product->discount = $request['discount_'.$product];
                $flash_deal_product->discount_type = $request['discount_type_'.$product];
                $flash_deal_product->save();
            }

            $flash_deal_translation = FlashDealTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'flash_deal_id' => $flash_deal->id]);
            $flash_deal_translation->title = $request->title;
            $flash_deal_translation->save();

            flash(translate('Flash Deal has been inserted successfully'))->success();
            return redirect()->route('seller.marketing');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }
}
