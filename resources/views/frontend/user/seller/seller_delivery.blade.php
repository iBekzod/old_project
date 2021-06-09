@extends('frontend.layouts.app')


@section('css')
<style>
    .card{
        width: 85% !important;
        margin: 0 auto;
    }
    .container{
        width: 95% !important;
        margin: 0 auto;
    }
    p{
         font-size: 14px;
       /* padding-left: 30px; */
    }
    .right{
        float: right !important;
    }
</style>

@endsection
@section('content')

	<div class=" offset-sm-1 col-sm-10">
        <div class="card">
            <div class="container px-5">
                    <div class="row">
                        <div class="col-md-12 mt-4 text-center my-2">
                           <h5> <b>Договор на оказание курьерских услуг № </b> </h5>
                        </div>
                        {{-- <div class="col-md-12 mt-4 text-center">
                              <h1 class="text-danger">{{ $seller['Название_магазина'] }}</h1>
                        </div> --}}
                        <div class="col-md-4">
                            <p> «____» ___________20__ года. </p>
                        </div>
                        <div class=" offset-md-4 col-md-4">
                             <div class="right">
                               <p>г. Ташкент</p>
                             </div>
                        </div>

                   </div>
                   <div class="row">
                           <div class="col-md-12">
                               <p>Общество с Ограниченной Ответственностью <b>«TINFIS Cargo»</b> , в лице директора Каримова Д.Р. действующего на основании Устава, именуемое в дальнейшем «Исполнитель», с одной стороны, и « <span class="text-danger">firma nomi</span>  », в лице руководителя <span class="text-danger">firma  derektori ism familya</span> , действующего на основании  Устава, именуемое в дальнейшем «Заказчик», с другой стороны, вместе именуемые в дальнейшем «Стороны» и по отдельности «Сторона», заключили настоящий договор о нижеследующем:
                            </p>
                          </div>
                           <div class="col-md-12">
                               <div class="text-center">
                                 <p > <b>1. Предмет Договора</b></p>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <p>
                                   1.1. Заказчик поручает и оплачивает, а Исполнитель принимает на себя обязательства по оказанию услуг по доставке, а в случае необходимости, временному хранению различного рода отправлений в соответствии с видом доставки и категорией срочности (далее по тексту «Услуги») в пределах городов и районов Республики Узбекистан, а также осуществлять прием платежей за отправления с наложенным платежом от физических и юридических лиц (далее по тексту «Плательщики»). Заказчик обязуется оплачивать эти услуги.
                                   {{-- <i class="fal fa-check"></i> --}}
                                </p>
                           </div>
                   </div>
                   <div class="row">

                   </div>
                   <div class="row">
                       <div class="col-md-12 mt-4 text-center">
                          <p><b>13. РЕКВИЗИТЫ СТОРОН</b></p>
                       </div>
                       <div class=" offset-md-2 col-md-3">
                           <p><b>ИСПОЛНИТЕЛЬ</b></p>
                       </div>
                       <div class=" offset-md-3 col-md-2">
                            <div class="right">
                              <p><b>ЗАКАЗЧИК</b></p>
                            </div>
                       </div>
                  </div>
                  <div class="row">
                          <div class="col-md-12">
                              <div class="row">
                                    <div class="col-md-6"><p>Название: ООО «BMG HI-TECH</p> </div>
                                    <div class="col-md-6"><p>Название: </p> </div>
                              </div>
                              <div class="row">
                                    <div class="col-md-6"><p>Адрес: 100029 г. Ташкент, Мирабадский р-он   ул. Афросиаб 12 б </p></div>
                                    <div class="col-md-6"><p>Адрес: </p> </div>
                              </div>
                               <div class="row">
                                   <div class="col-md-6"><p>Банк: Алока банк </p> </div>
                                   <div class="col-md-6"><p> Банк:</p></div>
                              </div>
                               <div class="row">
                                   <div class="col-md-6"><p>МФО: 00401</p> </div>
                                   <div class="col-md-6"><p>МФО:</p> </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-6"><p>р/с: 2020 8000 2009 7992 2001 </p></div>
                                   <div class="col-md-6"><p>р/с:</p> </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-6"><p>ИНН: 306018564 </p> </div>
                                   <div class="col-md-6"><p> ИНН:</p></div>
                               </div>
                               <div class="row">
                                   <div class="col-md-6">
                                       <p>Тел раб: 78 150 8 150</p>
                                   </div>
                                   <div class="col-md-6"> <p>Тел раб: </p>  </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-6">
                                       <p>e-mail: bmgventure@gmail.com </p>
                                   </div>
                                   <div class="col-md-6"> <p>e-mail:  </p>  </div>
                               </div>
                               <div class="row">
                                   <div class="col-md-6">
                                       <p>Руководитель <br>
                                           /Джаббаров И.Г./</p>
                                   </div>
                                   <div class="col-md-6">
                                       <p>Руководитель <br>
                                          <b></b>
                                       </p>
                                  </div>
                               </div>
                          </div>
                    </div>

            </div>
        </div>


	</div>

@endsection

@section('script')
	<script type="text/javascript">


	</script>
@endsection

