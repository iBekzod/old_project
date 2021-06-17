<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Shop;
use App\User;
use Auth;
use App\Seller;
use App\BusinessSetting;
use Illuminate\Support\Arr;

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
            // "РС" => "11"
            // "ФИО_директора" => "Sunt in exercitation"
            // "Тел_директора" => "97"
            // "Электронная_почта_директора" => "mugafyd@mailinator.com"
            // "ФИО_менеджера_ответственного_за_сотрудничество" => "16"
            // "Тел_менеджера" => "33"
            // "Электронная_почта_менеджера" => "liqax@mailinator.com"

            // TODO::tak seller navicatdatoldirish kere inn validate save and login register pdf to html
             'user_id'=>'required',
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
            //    dd($array);
            $seller=new Seller;
            $data = array();
            $i = 0;
            foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
                $item = array();
                if ($element->type) {
                    $item['type'] = $element->type;
                    $item['label'] = $element->label;
                    $item['value'] = $request[$element->label];
                    // dd($request[]);
                }
                array_push($data, $item);
                $i++;
            }
            $seller->user_id=$request->user_id;
            $seller->verification_info = json_encode($data);
            //    dd($data);
            // $seller->save();
            //    dd($seller);
             $time=time();
             $date=date("d/m/Y",$time);
            //   dd($date);
            if($seller->save()){
                return view('frontend.user.seller.seller_autoidentification')->with('array', $array)->with('seller',$seller,)->with('date',$date);
            }



   }


}
