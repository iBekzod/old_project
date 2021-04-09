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
                                    <label class="col-md-2 col-form-label">{{ translate('Legal name') }}</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control"
                                               placeholder="{{ translate('Legal name') }}" name="name"
                                               value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-md-2 col-form-label">{{ translate('Full name of the director') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Full name of the director') }}"
                                               name="new_password">
                                    </div>
                                </div>
                                {{--                            <div class="form-group row">--}}
                                {{--                                <label class="col-md-2 col-form-label">{{ translate('Your Phone') }}</label>--}}
                                {{--                                <div class="col-md-10">--}}
                                {{--                                    <input type="text" class="form-control" placeholder="{{ translate('Your Phone')}}" name="phone" value="{{ Auth::user()->phone }}">--}}
                                {{--                                </div>--}}
                                {{--                            </div>--}}
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{ translate('Phone number') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Phone number') }}" name="new_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-md-2 col-form-label">{{ translate('Full name of the manager') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Full name of the manager') }}"
                                               name="new_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{ translate('Phone number') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Phone number') }}" name="new_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                                    <div class="col-md-10">
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div
                                                    class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="photo"
                                                   value="{{ Auth::user()->avatar_original }}" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{ translate('Your Password') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Your Password') }}" name="new_password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">{{ translate('Confirm Password') }}</label>
                                    <div class="col-md-10">
                                        <input type="password" class="form-control"
                                               placeholder="{{ translate('Confirm Password') }}"
                                               name="confirm_password">
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
                                                        <span
                                                            class="badge badge-inline badge-primary">{{ translate('Default') }}</span>
                                                    </div>
                                                @endif
                                                <div class="top-0 right-0 dropdown position-absolute">
                                                    <button class="px-2 btn bg-gray" type="button"
                                                            data-toggle="dropdown">
                                                        <i class="la la-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenuButton">
                                                        @if (!$address->set_default)
                                                            <a class="dropdown-item"
                                                               href="{{ route('addresses.set_default', $address->id) }}">{{ translate('Make This Default') }}</a>
                                                        @endif
                                                        <a class="dropdown-item"
                                                           href="{{ route('addresses.destroy', $address->id) }}">{{ translate('Delete') }}</a>
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
                                    <label class="col-md-3 col-form-label">{{ translate('Bank Name') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="mb-3 form-control"
                                               placeholder="{{ translate('Bank Name')}}"
                                               value="{{ Auth::user()->seller->bank_name }}" name="bank_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">{{ translate('Bank Account Name') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="mb-3 form-control"
                                               placeholder="{{ translate('Bank Account Name')}}"
                                               value="{{ Auth::user()->seller->bank_acc_name }}" name="bank_acc_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <label
                                        class="col-md-3 col-form-label">{{ translate('Bank Account Number') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="mb-3 form-control"
                                               placeholder="{{ translate('Bank Account Number')}}"
                                               value="{{ Auth::user()->seller->bank_acc_no }}" name="bank_acc_no">
                                    </div>
                                </div>
                                <div class="row">
                                    <label
                                        class="col-md-3 col-form-label">{{ translate('Bank Routing Number') }}</label>
                                    <div class="col-md-9">
                                        <input type="number" lang="en" class="mb-3 form-control"
                                               placeholder="{{ translate('Bank Routing Number')}}"
                                               value="{{ Auth::user()->seller->bank_routing_no }}"
                                               name="bank_routing_no">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">{{ translate('T.I.N') }}</label>
                                    <div class="col-md-9">
                                        <input type="number" lang="en" class="mb-3 form-control"
                                               placeholder="{{ translate('T.I.N')}}"
                                               value="{{ Auth::user()->seller->bank_routing_no }}"
                                               name="bank_routing_no">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">{{ translate('Cash Payment') }}</label>
                                    <div class="col-md-9">
                                        <label class="mb-3 aiz-switch aiz-switch-success">
                                            <input value="1" name="cash_on_delivery_status" type="checkbox"
                                                   @if (Auth::user()->seller->cash_on_delivery_status == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-3 col-form-label">{{ translate('Bank Payment') }}</label>
                                    <div class="col-md-9">
                                        <label class="mb-3 aiz-switch aiz-switch-success">
                                            <input value="1" name="bank_payment_status" type="checkbox"
                                                   @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Set up payments')}}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-md-3 col-form-label">{{ translate('Cash') }}</label>
                                    <div class="col-md-9">
                                        <label class="mb-3 aiz-switch aiz-switch-success">
                                            <input value="1" name="bank_payment_status" type="checkbox"
                                                   @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <label class="col-md-3 col-form-label">{{ translate('Online Payment') }}</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="mb-3 aiz-switch aiz-switch-success ml-5"><span class="h5">UZS</span>
                                                    <input value="1" name="bank_payment_status" type="checkbox"
                                                           @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-3 aiz-switch aiz-switch-success"><span class="h5">USD</span>
                                                    <input value="1" name="bank_payment_status" type="checkbox"
                                                           @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <label class="col-md-3 col-form-label">{{ translate('Terminals') }}</label>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="mb-3 aiz-switch aiz-switch-success"><img class="w-80px" src="data:image/jpeg;base64,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" alt="">
                                                    <input value="1" name="bank_payment_status" type="checkbox"
                                                           @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-3 aiz-switch aiz-switch-success"><img class="w-80px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMhbVxB7d2elNmXfZD1WZDQsr80RH0uDhwbrELrShJceF8kuVy7D6sAGe4_c33OtNuyCo&usqp=CAU" alt="">
                                                    <input value="1" name="bank_payment_status" type="checkbox"
                                                           @if (Auth::user()->seller->bank_payment_status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0 text-right form-group">
                            <button type="submit" class="btn btn-primary">{{translate('Update Profile')}}</button>
                        </div>
                    </form>
                    <br>

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
                                            <input type="email" class="form-control"
                                                   placeholder="{{ translate('Your Email')}}" name="email"
                                                   value="{{ Auth::user()->email }}"/>
                                            <div class="input-group-append">
                                                <button type="button"
                                                        class="btn btn-outline-secondary new-email-verification">
                                           <span class="d-none loading">
                                               <span class="spinner-border spinner-border-sm" role="status"
                                                     aria-hidden="true"></span>{{ translate('Sending Email...') }}
                                           </span>
                                                    <span class="default">{{ translate('Verify') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-0 text-right form-group">
                                            <button type="submit"
                                                    class="btn btn-primary">{{translate('Update Email')}}</button>
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
    <div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                                    <textarea class="mb-3 form-control" placeholder="{{ translate('Your Address')}}"
                                              rows="2" name="address" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="mb-3">
                                        <select class="form-control aiz-selectpicker" data-live-search="true"
                                                data-placeholder="{{ translate('Select your country')}}" name="country"
                                                required>
                                            @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="longitude" value="">
                            <input type="hidden" name="latitude" value="">
                            <div id="map_canvas">

                            </div>
                            @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'area_wise_shipping')
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('City')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="mb-3 form-control aiz-selectpicker" data-live-search="true"
                                                name="city" required>
                                            @foreach (\App\City::get() as $key => $city)
                                                <option
                                                    value="{{ $city->name }}">{{ $city->getTranslation('name') }}</option>
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
                                        <input type="text" class="mb-3 form-control"
                                               placeholder="{{ translate('Your City')}}" name="city" value="" required>

                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Postal code')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="mb-3 form-control"
                                           placeholder="{{ translate('Your Postal Code')}}" name="postal_code" value=""
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone')}}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="mb-3 form-control" placeholder="{{ translate('+998')}}"
                                           name="phone" value="" required>
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
        function add_new_address() {
            $('#new-address-modal').modal('show');
        }

        $('.new-email-verification').on('click', function () {
            $(this).find('.loading').removeClass('d-none');
            $(this).find('.default').addClass('d-none');
            var email = $("input[name=email]").val();

            $.post('{{ route('user.new.verify') }}', {_token: '{{ csrf_token() }}', email: email}, function (data) {
                data = JSON.parse(data);
                $('.default').removeClass('d-none');
                $('.loading').addClass('d-none');
                if (data.status == 2)
                    AIZ.plugins.notify('warning', data.message);
                else if (data.status == 1)
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
