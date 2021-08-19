@extends('frontend.layouts.seller')

@section('content')
<section class="py-5">
    <div class="container" >
        <div class="d-flex align-items-start">
            @include('frontend.inc.user_side_nav')
            <div class="aiz-user-panel">
                <div class="mt-2 mb-4 aiz-titlebar">
                  <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="h3">{{ translate('Manage Profile') }}</h1>
                    </div>
                  </div>
                </div>
                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Basic Info-->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Basic Info')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Name') }}</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="{{ translate('Your Name') }}" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Phone') }}</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="{{ translate('Your Phone')}}" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                                <div class="col-md-10">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Password') }}</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="{{ translate('New Password') }}" name="new_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Confirm Password') }}</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="{{ translate('Confirm Password') }}" name="confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    {{-- @if(Auth::user()->has('addresses')) --}}
                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Address')}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row gutters-10">
                                @foreach ($addresses=Auth::user()->addresses as $key => $address)
                                    <div class="col-lg-6">
                                        <div class="p-3 pr-5 mb-3 border rounded position-relative">
                                            <div>
                                                <span class="w-50 fw-600">{{ translate('Address') }}:</span>
                                                <span class="ml-2">{{ $address->address }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600">{{ translate('Postal Code') }}:</span>
                                                <span class="ml-2">{{ $address->postal_code }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600">{{ translate('City') }}:</span>
                                                <span class="ml-2">{{$address->city}}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600">{{ translate('Country') }}:</span>
                                                <span class="ml-2">{{ $address->country }}</span>
                                            </div>
                                            <div>
                                                <span class="w-50 fw-600">{{ translate('Phone') }}:</span>
                                                <span class="ml-2">{{ $address->phone }}</span>
                                            </div>
                                            @if ($address->set_default)
                                                <div class="bottom-0 right-0 pb-3 pr-2 position-absolute">
                                                    <span class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                                                </div>
                                            @endif
                                            <div class="top-0 right-0 dropdown position-absolute">
                                                <button class="px-2 btn bg-gray" type="button" data-toggle="dropdown">
                                                    <i class="la la-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    @if (!$address->set_default)
                                                        <a class="dropdown-item" href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                                    @endif
                                                    <a class="dropdown-item" href="{{ route('addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mx-auto col-lg-6" onclick="add_new_address()">
                                    <div class="p-3 mb-3 text-center border rounded c-pointer bg-light">
                                        <i class="la la-plus la-2x"></i>
                                        <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- @endif --}}
                    <!-- Payment System -->
                    <div class="card">
                      <div class="card-header">
                          <h5 class="mb-0 h6">{{ translate('Payment Setting')}}</h5>
                      </div>
                      <div class="card-body">
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ translate('Cash Payment') }}</label>
                            <div class="col-md-9">
                                <label class="mb-3 aiz-switch aiz-switch-success">
                                    <input value="1" name="cash_on_delivery_status" type="checkbox" @if (Auth::user()->seller->cash_on_delivery_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">{{ translate('Bank Payment') }}</label>
                            <div class="col-md-9">
                                <label class="mb-3 aiz-switch aiz-switch-success">
                                    <input value="1" name="bank_payment_status" type="checkbox" @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                      </div>
                  </div>
                  <div class="mb-0 text-right form-group">
                      <button type="submit" class="btn btn-primary">{{translate('Update Profile')}}</button>
                  </div>
                </form>
                <br>

                <!--Seller Verification Form -->
                <form action="{{ route('update.autoidentification') }}" method="POST">
                   @csrf
                   <div class="card">
                       <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Seller Verification Form')}}</h5>
                       </div>
                       <div class="card-body">
                        <div class="form-group row">
                            <div class=" offset-lg-1 col-lg-11 form-horizontal" id="form">
                                <div class="row m-0 p-0">
                                    <div class="col-lg-12 m-0 p-0">
                                            @foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)
                                                @if($element->type=='text')
                                                    <div class="form-group row" id="category">
                                                        @if ($element->label=='forma_sobstvennosti')

                                                            <label class="col-lg-3 col-from-label mb-2"> {{translate($element->name)}}</label>
                                                            <div class="col-lg-8">
                                                                <select name="{{($element->label)}}" value="{{$information[$key]['value']?? ""}}" class="form-control py-2">
                                                                    <option @if($information[$key]['value']=="OАО") selected @endif value="OАО">OАО</option>
                                                                    <option @if($information[$key]['value']=="ЗАО") selected @endif  value="ЗАО">ЗАО</option>
                                                                    <option @if($information[$key]['value']=="ООО") selected @endif  value="ООО">ООО</option>
                                                                    <option @if($information[$key]['value']=="Частное предприятие") selected @endif  value="Частное предприятие">Частное предприятие</option>
                                                                    <option @if($information[$key]['value']=="Частный предприниматель") selected @endif  value="Частный предприниматель">Частный предприниматель</option>
                                                                    <option @if($information[$key]['value']=="СП") selected @endif  value="СП">СП</option>
                                                                    <option @if($information[$key]['value']=="ИП") selected @endif  value="ИП">ИП</option>
                                                                    <option @if($information[$key]['value']=="ГУП") selected @endif  value="ГУП">ГУП</option>
                                                                    <option @if($information[$key]['value']=="Семейное предприятие") selected @endif  value="Семейное предприятие">Семейное предприятие</option>
                                                                    <option @if($information[$key]['value']=="Фермерское хозяйство") selected @endif  value="Фермерское хозяйство">Фермерское хозяйство</option>
                                                                    <option @if($information[$key]['value']=="Частное лицо") selected @endif  value="Частное лицо">Частное лицо</option>
                                                                </select>
                                                            </div>
                                                        @else
                                                            <label class="col-lg-3 col-from-label mb-2"> {{translate($element->name)}}</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" value="{{$information[$key]['value']?? ""}}" name="{{($element->label)}}" required>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif($element->type=='number')
                                                    <div class="form-group row" id="category">
                                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->name)}}</label>
                                                        <div class="col-lg-8">
                                                        <input class="form-control" type="number" value="{{$information[$key]['value']?? "kemadi"}}" name="{{($element->label)}}" required>
                                                        </div>
                                                    </div>
                                                @elseif($element->type=='email')
                                                    <div class="form-group row" id="category">
                                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->name)}}</label>
                                                        <div class="col-lg-8">
                                                        <input class="form-control" type="email" value="{{$information[$key]['value']?? "kemadi"}}" name="{{($element->label)}}" required>
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
                                                id="country_dd" name="country_id">
                                                <option value="0">{{ translate('All countries') }}</option>

                                                {{-- <option value="{{$country->id}}">{{$country->name}}</option> --}}
                                                @foreach (App\Country::where('status', 1)->get() as $data)
                                                    <option @if(App\Country::where('code', 'UZ')->first()->id==$data->id) selected @endif value="{{$data->id}}">
                                                        {{$data->getTranslation('name')}}
                                                    </option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <div class=" col-lg-3" style="display:inline-block">
                                            <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                            id="state_dd" name="region_id" >
                                            @foreach($regions as $data)

                                                <option @if($selected_region->id==$data->id) selected @endif value="{{$data->id}}">
                                                    {{$data->getTranslation('name')}}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3" style="display:inline-block">
                                            <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                                            id="city_dd"  name="city_id" >
                                                {{-- <option value="0">{{ translate('All citys') }}</option> --}}
                                                @foreach ($cities as $data)
                                                <option @if($selected_city->id==$data->id) selected @endif value="{{$data->id}}">
                                                    {{$data->getTranslation('name')}}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-md-12 p-0">
                                           <div class="form-inline justify-content-center">

                                               {{-- <input id="address" type="textbox" style="width:40%" value="tashken"> --}}
                                               {{-- <input type="button" class="btn-outline-info p-2 " style="display: inline-block" value="Geocode" onclick="codeAddress()"> <br> --}}
                                               <label for="lat" class="p-2">{{translate('Latitude:')}}</label>
                                               <input type="text" id="lat" class="p-2" value="{{$addresses->latitude ?? "" }}" name="latitude"/>
                                               <label for="lat" class="p-2">{{translate('Longitude:')}}</label>
                                               <input type="text" id="lng" class="p-2" value="{{$addresses->longitude ?? "" }}" name="longitude"/>
                                               {{-- @dd($addresses->latitude) --}}
                                           </div>
                                           <div id="map_canvas" class="my-2" style="width:95%; height:300px;"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-0 text-right form-group">
                                        <button type="submit" class="btn btn-primary">{{translate('Update Form')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   </div>
                </form>


                <!-- Change Email -->
                <form action="{{ route('user.change.email') }}" method="POST">
                    @csrf
                    <div class="card">
                      <div class="card-header">
                          <h5 class="mb-0 h6">{{ translate('Change your email')}}</h5>
                      </div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-md-2">
                                  <label>{{ translate('Your Email') }}</label>
                              </div>
                              <div class="col-md-10">
                                  <div class="mb-3 input-group">
                                    <input type="email" class="form-control" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                                    <div class="input-group-append">
                                       <button type="button" class="btn btn-outline-secondary new-email-verification">
                                           <span class="d-none loading">
                                               <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>{{ translate('Sending Email...') }}
                                           </span>
                                           <span class="default">{{ translate('Verify') }}</span>
                                       </button>
                                    </div>
                                  </div>
                                  <div class="mb-0 text-right form-group">
                                      <button type="submit" class="btn btn-primary">{{translate('Update Email')}}</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Address')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="mb-3 form-control" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Country')}}</label>
                            </div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country')}}" name="country" required>
                                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden"  name="longitude" value="">
                        <input type="hidden"  name="latitude" value="">
                        <div id="map_canvas" >

                        </div>
                        @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'area_wise_shipping')
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="mb-3 form-control aiz-selectpicker" data-live-search="true" name="city" required>
                                        {{-- @foreach (\App\City::get() as $key => $city)
                                            <option value="{{ $city->name }}">{{ $city->getTranslation('name') }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="mb-3 form-control" placeholder="{{ translate('Your City')}}" name="city" value="" required>

                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Postal code')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="mb-3 form-control" placeholder="{{ translate('Your Postal Code')}}" name="postal_code" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Phone')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="mb-3 form-control" placeholder="{{ translate('+998')}}" name="phone" value="" required>
                            </div>
                        </div>
                        <div class="text-right form-group">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
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
        // function add_new_address(){
        //     $('#new-address-modal').modal('show');
        // }

        // $('.new-email-verification').on('click', function() {
        //     $(this).find('.loading').removeClass('d-none');
        //     $(this).find('.default').addClass('d-none');
        //     var email = $("input[name=email]").val();

        //     $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
        //         data = JSON.parse(data);
        //         $('.default').removeClass('d-none');
        //         $('.loading').addClass('d-none');
        //         if(data.status == 2)
        //             AIZ.plugins.notify('warning', data.message);
        //         else if(data.status == 1)
        //             AIZ.plugins.notify('success', data.message);
        //         else
        //             AIZ.plugins.notify('danger', data.message);
        //     });
        // });

        // function initialize() {

        //     var map_canvas = document.getElementById('map_canvas');

        //     // Initialise the map
        //     var map_options = {
        //         center: location,
        //         zoom: 10,
        //         mapTypeId: google.maps.MapTypeId.ROADMAP
        //     }
        //     var map = new google.maps.Map(map_canvas, map_options)

        //     // Put all locations into array
        //     var locations = [
        //         foreach($addresses as $location)
        //             [  $location->latitude ,  $location->longitude  ]
        //         endforeach

        //     ];

        //     for (i = 0; i < locations.length; i++) {
        //         var location = new google.maps.LatLng(locations[i][0], locations[i][1]);
        //         var marker = new google.maps.Marker({
        //             position: location,
        //             map: map,
        //         });
        //     }

        //     marker.setMap(map); // Probably not necessary since you set the map above

        // }
    </script>

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
                var address=this.options[this.selectedIndex].text;
                setAddressGeo(address, 5);
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
                var address=this.options[this.selectedIndex].text;
                setAddressGeo(address, 9);
            });

            $('#city_dd').on('change', function () {
                var address=this.options[this.selectedIndex].text;
                setAddressGeo(address, 11);
            });


            // setAddressGeo('{{$selected_city->name}}', 11);
        });

        var geocoder;
        var map;
        var mapOptions = {
            zoom: 9,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
        var marker;

        function initialize() {
          geocoder = new google.maps.Geocoder();
          map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        //   codeAddress();

          setAddressGeo('{{$selected_city->name}}', 15, '{{$addresses->latitude??0}}', '{{$addresses->longitude??0}}');
        }


        function setAddressGeo(address, my_zoom=9, lat_=0, lng_=0){
            if(address==""){
                address='toshkent';
            }
            map.setZoom(my_zoom);
            // a=getElementById('lat').value;
            // b=getElementById('lng').value;
            // console.log(lat);
            // console.log(lng);
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    position_=results[0].geometry.location;
                    // alert(position_)
                    if(lat_!=0 && lng_!=0){
                        position_ = new google.maps.LatLng(lat_, lng_);
                    }
                    map.setCenter(position_);
                    if(marker)
                        marker.setMap();
                    marker = new google.maps.Marker({
                        map: map,
                        // position:{lat=40.1250439,lng=67.8808243},
                        position: position_,
                        draggable: true,



                    });
                    // alert(results[0].geometry.location.lat());
                    // alert(results[0].geometry.location.lng());
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

        function city_selected(){
            var address=$('#city_dd').options[$('#city_dd').selectedIndex].text;
            setAddressGeo(address, 11);
        }
    </script>

@endsection

@section('script')

@endsection
