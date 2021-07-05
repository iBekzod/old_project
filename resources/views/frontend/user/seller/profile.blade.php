@extends('frontend.layouts.seller')

@section('content')
<section class="py-5">
    <div class="container">
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
                    <div class="card">
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
                                                <span class="ml-2">{{ $address->city }}</span>
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
                    </div>
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
                <form action="" method="POST">
                   @csrf
                   <div class="card">
                       <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Seller Verification Form')}}</h5>
                       </div>
                       <div class="card-body">
                        <div class="form-group row">
                            <div class=" col-lg-12 form-horizontal" id="form">

                                @foreach (json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element)

                                    @if($element->type=='text')
                                    <div class="form-group row" id="category">
                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                        <div class="col-lg-9">
                                        <input class="form-control" type="text" name="{{($element->label)}}" required>
                                        </div>
                                    </div>
                                    @elseif($element->type=='number')
                                    <div class="form-group row" id="category">
                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                        <div class="col-lg-9">
                                        <input class="form-control" type="number" name="{{($element->label)}}" required>
                                        </div>
                                    </div>
                                    @elseif($element->type=='email')
                                    <div class="form-group row" id="category">
                                        <label class="col-lg-3 col-from-label mb-2"> {{translate($element->label)}}</label>
                                        <div class="col-lg-9">
                                        <input class="form-control" type="email" name="{{($element->label)}}" required>
                                        </div>
                                    </div>
                                    @endif


                                @endforeach
                                <div class="mb-0 text-right form-group">
                                    <button type="submit" class="btn btn-primary">{{translate('Update Form')}}</button>
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
                                        @foreach (\App\City::get() as $key => $city)
                                            <option value="{{ $city->name }}">{{ $city->getTranslation('name') }}</option>
                                        @endforeach
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
        function add_new_address(){
            $('#new-address-modal').modal('show');
        }

        $('.new-email-verification').on('click', function() {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var email = $("input[name=email]").val();

            $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if(data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if(data.status == 1)
                    AIZ.plugins.notify('success', data.message);
                else
                    AIZ.plugins.notify('danger', data.message);
            });
        });

        function initialize() {

            var map_canvas = document.getElementById('map_canvas');

            // Initialise the map
            var map_options = {
                center: location,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(map_canvas, map_options)

            // Put all locations into array
            var locations = [
                @foreach($addresses as $location)
                    [ {{ $location->latitude }}, {{ $location->longitude }} ]
                @endforeach

            ];

            for (i = 0; i < locations.length; i++) {
                var location = new google.maps.LatLng(locations[i][0], locations[i][1]);
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });
            }

            marker.setMap(map); // Probably not necessary since you set the map above

        }
    </script>
@endsection
