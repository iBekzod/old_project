<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerAutoidentificationFormController extends Controller
{
   public function seller_autoidentification_form_save(Request $request)
   {
        $array=$request->all();
       // dd($array);
         return view('frontend.user.seller.seller_autoidentification')->with('seller', $array);


//         array:16 [▼
//   "_token" => "mKwvvtIilbaECnk7ori22QVVNNaquf2ycAGzIaXu"
//   "Форма_собственности" => "Lorem at fuga Animi"
//   "Юридическое_название_вендора" => "Quod iure impedit a"
//   "Название_магазина" => "Quis quos ex rerum v"
//   "Адрес_регистрации_вендора" => "Illo in ut magna tem"
//   "Физический_адрес_вендора" => "Et unde sunt nostrud"
//   "ИНН" => "26"
//   "Название_банка" => "Commodo non fugiat"
//   "МФО_банка" => "9"
//   "Р/С" => "33"
//   "ФИО_директора" => "Eos ea ratione quo e"
//   "Тел_директора" => "55"
//   "Электронная_почта_директора" => "tahahe@mailinator.com"
//   "ФИО_менеджера_ответственного_за_сотрудничество" => "11"
//   "Тел_менеджера" => "55"
//   "Электронная_почта_менеджера" => "lifi@mailinator.com"
// ]
   }


}
