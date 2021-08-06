@extends('frontend.layouts.app')

@section('content')

	<div class=" offset-sm-1 col-sm-10">

		<div class="card">
			<div class="card-header">
				<h5 class="mb-0 h6">{{translate('Seller Verification Form')}}</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('seller.autoidentification') }}" method="post">
					@csrf

					<div class="row">
						<div class=" offset-lg-1 col-lg-11 form-horizontal" id="form">


                           <div class="row">
                               <div class="col-md-12">
                                        @foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)
                                        @if($element->type=='text')
                                        <div class="form-group row" id="category">
                                            @if ($element->label=='Форма_собственности')

                                            <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                            <div class="col-lg-8">
                                                <select name="{{($element->label)}}" class="form-control py-2">
                                                    <option value="OАО">OАО</option>
                                                    <option value="ЗАО">ЗАО</option>
                                                    <option value="ООО">ООО</option>
                                                    <option value="Частное предприятие">Частное предприятие</option>
                                                    <option value="Частный предприниматель">Частный предприниматель</option>
                                                    <option value="СП">СП</option>
                                                    <option value="ИП">ИП</option>
                                                    <option value="ГУП">ГУП</option>
                                                    <option value="Семейное предприятие">Семейное предприятие</option>
                                                    <option value="Фермерское хозяйство">Фермерское хозяйство</option>
                                                    <option value="Частное лицо">Частное лицо</option>
                                                </select>
                                            </div>

                                            @else
                                                <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" name="{{($element->label)}}" required>
                                                </div>
                                            @endif
                                        </div>
                                        @elseif($element->type=='number')
                                        <div class="form-group row" id="category">
                                            <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                            <div class="col-lg-8">
                                            <input class="form-control" type="number" name="{{($element->label)}}" required>
                                            </div>
                                        </div>
                                        @elseif($element->type=='email')
                                        <div class="form-group row" id="category">
                                            <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                            <div class="col-lg-8">
                                            <input class="form-control" type="email" name="{{($element->label)}}" required>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                               </div>
                           </div>
                           <div class="row">
                                    <div class=" col-lg-11 my-2 form-horizontal">
                                        <h5 class="mb-0">{{translate('Address Seller')}}</h5>
                                        <hr>
                                    </div>
                                    <div class=" col-lg-5 pl-0" style="display:inline-block">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                            id="country_dd" name="country_id" onchange="sort_elements()">
                                            <option value="0">{{ translate('All countries') }}</option>

                                            {{-- <option value="{{$country->id}}">{{$country->name}}</option> --}}
                                            @foreach ($countrys as $data)
                                                    <option value="{{$data->id}}">
                                                        {{$data->name}}

                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class=" col-lg-3" style="display:inline-block">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                        id="state_dd" name="region_id" onchange="sort_elements()">
                                            {{-- <option value="0">{{ translate('All regions') }}</option> --}}


                                        </select>
                                    </div>
                                    <div class="col-lg-3" style="display:inline-block">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                        id="city_dd"  name="city_id" onchange="sort_elements()">
                                            {{-- <option value="0">{{ translate('All citys') }}</option> --}}


                                        </select>
                                    </div>


                           </div>
                           <div class="row my-3">
                             <div class="col-md-12 p-0">
                                    <div>
                                        <div class="row">

                                        </div>
                                        <input id="address" type="textbox" style="width:40%" value="tashken">
                                        <input type="button" value="Geocode" onclick="codeAddress()"> <br>
                                        <label for="lat">latitude:</label>
                                        <input type="text" id="lat" name="latitude"/>
                                        <label for="lat">longitude:</label>
                                        <input type="text" id="lng" name="longitude"/>

                                    </div>
                                    <div id="map_canvas" class="my-2" style="width:95%; height:300px;"></div>
                             </div>
                           </div>
                            <div class="row">
                                <div class="form-group text-right  mr-4 mt-3 ">
                                    <button type="submit" class="btn btn-primary py-2">{{translate('Save')}}</button>
                                </div>
                            </div>
                        </div>

					</div>
				</form>
			</div>

		</div>

	</div>

@endsection

@section('script')
	<script type="text/javascript">


        $(document).ready(function () {
                    $('#country_dd').on('change', function () {
                        var idCountry = this.value;
                        $("#state_dd").html('');
                        $.ajax({
                            url: "{{url('api/fetch-states')}}",
                            type: "POST",
                            data: {
                                country_id: idCountry,
                                _token: '{{csrf_token()}}'
                            },
                            dataType: 'json',
                            success: function (result) {
                                $('#state_dd').html('<option value="">All regions</option>');
                                $.each(result.states, function (key, value) {
                                    $("#state_dd").append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                                $('#city_dd').html('<option value="">All citys</option>');
                            }
                        });
                    });
                    $('#state_dd').on('change', function () {
                        var idState = this.value;
                        $("#city_dd").html('');
                        $.ajax({
                            url: "{{url('api/fetch-cities')}}",
                            type: "POST",
                            data: {
                                state_id: idState,
                                _token: '{{csrf_token()}}'
                            },
                            dataType: 'json',
                            success: function (res) {
                                // alert(res.cities);
                                $('#city_dd').html('<option value="">All citys</option>');
                                $.each(res.cities, function (key, value) {
                                var inform = $("#city_dd").append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                            }
                        });
                    });
                });
	</script>
     <script>
        var geocoder;
        var map;
        var mapOptions = {
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
        var marker;

        function initialize() {
          geocoder = new google.maps.Geocoder();
          map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
          codeAddress();
        }


        function codeAddress() {
        var ali=document.getElementById('city_dd').value;
        if (ali==="") {
            var person="kemadi";
          console.log(person);
        }
        else{
             console.log(ali);
             

        }



            var address = document.getElementById('address').value;
          geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              if(marker)
                marker.setMap(null);
              marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location,
                  draggable: true
              });
              google.maps.event.addListener(marker, "dragend", function() {
                document.getElementById('lat').value = marker.getPosition().lat();
                document.getElementById('lng').value = marker.getPosition().lng();
              });
              document.getElementById('lat').value = marker.getPosition().lat();
              document.getElementById('lng').value = marker.getPosition().lng();
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        }
      </script>










@endsection



