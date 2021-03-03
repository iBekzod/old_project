<?php

namespace App\Http\View\Composers;
use Illuminate\View\View;

class AdminPageComposer
{

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
    $vendor_system_activation = \App\BusinessSetting::where('type', 'vendor_system_activation')->first();
    $classified_product =       \App\BusinessSetting::where('type', 'classified_product')->first();
    $addons = \App\Addon::where(function ($query) {
        $query->where('unique_identifier', 'african_pg');
        $query->where('unique_identifier', 'pos_system');
        $query->where('unique_identifier', 'refund_request');
        $query->where('unique_identifier', 'otp_system');
        $query->where('unique_identifier', 'affiliate_system');
        $query->where('unique_identifier', 'offline_payment');
        $query->where('unique_identifier', 'seller_subscription');
        $query->where('unique_identifier', 'paytm');
        $query->where('unique_identifier', 'club_point');
    })->get();
    $afr_pg =               $addons->where('unique_identifier', 'african_pg')->first();
    $pos_system =           $addons->where('unique_identifier', 'pos_system')->first();
    $refund_request =       $addons->where('unique_identifier', 'refund_request')->first();
    $otp_system =           $addons->where('unique_identifier', 'otp_system')->first();
    $affiliate_system =     $addons->where('unique_identifier', 'affiliate_system')->first();
    $offline_payment =      $addons->where('unique_identifier', 'offline_payment')->first();
    $seller_subscription =  $addons->where('unique_identifier', 'seller_subscription')->first();
    $paytm =                $addons->where('unique_identifier', 'paytm')->first();
    $club_point =           $addons->where('unique_identifier', 'club_point')->first();

        $view->with([
            'vendor_system_activation',
            'classified_product',
            'afr_pg',
            'pos_system',
            'refund_request',
            'otp_system',
            'affiliate_system',
            'offline_payment',
            'seller_subscription',
            'paytm',
            'club_point'
        ]);
    }
}
