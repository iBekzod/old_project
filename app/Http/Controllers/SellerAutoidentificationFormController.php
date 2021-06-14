<?php

namespace App\Http\Controllers;

use App\Seller;
use App\SellerAutoidntification;
use Illuminate\Http\Request;

class SellerAutoidentificationFormController extends Controller
{
   public function seller_autoidentification_form_save(Request $request)
   {


        $request->validate([

            // "Форма_собственности" => "Laborum Ullam nesci"
            // "Юридическое_название_вендора" => "Repudiandae laborum"
            // "Название_магазина" => "Eu aut irure expedit"
            // "Адрес_регистрации_вендора" => "Dolore nihil in veri"
            // "Физический_адрес_вендора" => "Deserunt necessitati"
            // "ИНН" => "8"
            // "Название_банка" => "Cum aut dicta sint a"
            // "МФО_банка" => "86"
            // "Р/С" => "11"
            // "ФИО_директора" => "Sunt in exercitation"
            // "Тел_директора" => "97"
            // "Электронная_почта_директора" => "mugafyd@mailinator.com"
            // "ФИО_менеджера_ответственного_за_сотрудничество" => "16"
            // "Тел_менеджера" => "33"
            // "Электронная_почта_менеджера" => "liqax@mailinator.com"

            // TODO::tak seller navicatdatoldirish kere inn validate save and login register pdf to html
             'Форма_собственности'=> 'required',
             'Юридическое_название_вендора'=>'required',
             'Название_магазина'=>'required',
             'Адрес_регистрации_вендора'=>'required',
             'Физический_адрес_вендора'=>'required',
             'ИНН'=>'required',
             'Название_банка'=> 'required',
             'МФО_банка'=>'required',
             'РС'=>'required',
             'ФИО_директора'=>'required',
             'Тел_директора'=>'required',
             'Электронная_почта_директора'=>'required',
             'ФИО_менеджера_ответственного_за_сотрудничество'=> 'required',
             'Тел_менеджера'=>'required',
             'Электронная_почта_менеджера'=>'required'
            ]);
             $array=$request->all();
            // dd($array);
            $data= json_encode($array);
            $seller= new Seller;
            $seller->verification_info=$data;
        //   $seller->type_of_ownership=$request->Форма_собственности;
        //   $seller->vendor_legal_name=$request->Юридическое_название_вендора;
        //   $seller->name_of_shop=$request->Название_магазина;
        //   $seller->vendor_registration_address=$request->Адрес_регистрации_вендора;
        //   $seller->vendor_physical_address=$request->Физический_адрес_вендора;
        //   $seller->taxpayer_identification_number=$request->ИНН;
        //   $seller->bank_name=$request->Название_банка;
        //   $seller->mfo_bank=$request->МФО_банка;
        //   $seller->rc=$request->РС;
        //   $seller->full_name_director=$request->ФИО_директора;
        //   $seller->tel_director=$request->Тел_директора;
        //   $seller->email_director=$request->Электронная_почта_директора;
        //   $seller->name_responsible_manager=$request->ФИО_менеджера_ответственного_за_сотрудничество;
        //   $seller->tel_menager=$request->Тел_менеджера;
        //   $seller->email_manager=$request->Электронная_почта_менеджера;
             dd($seller);
         //  $seller->save();
        //   if($seller->save()){
        //    return view('frontend.user.seller.seller_autoidentification')->with('seller', $array);
        //   }

          return view('frontend.user.seller.seller_autoidentification')->with('seller', $array);

   }


}
