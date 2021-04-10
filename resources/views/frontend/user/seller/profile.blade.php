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
                        <style>
                            .inner{
                                position: relative;
                                bottom: 10px;
                                border-bottom: 0.8px solid #e8ebf1;
                            }
                        </style>
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
                               <div class="mt-3">
                                   <div class="row inner">
                                       <h5 class="h6  ml-2">{{ translate('Payment Setting')}}</h5>
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
                                   <div class="row pt-4">
                                       <label class="col-md-3 col-form-label">{{ translate('Online Payment') }}</label>
                                       <div class="col-md-9">
                                           <div class="row">
                                               <div class="col-md-2">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <span class="h5">UZS</span>
                                                       </label>
                                                   </div>
                                               </div>
                                               <div class="col-md-2">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <span class="h5">USD</span>
                                                       </label>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row pt-4">
                                       <label class="col-md-3 col-form-label">{{ translate('Terminals') }}</label>
                                       <div class="col-md-9">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <img class="w-50px" src="data:image/png;base64,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" alt="">
                                                       </label>
                                                   </div>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <img class=" w-50px" src="public/assets/img/Humo-01.png" alt="">
                                                       </label>
                                                   </div>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <img class=" w-50px" src="public/assets/img/credit+card+debit+payment+visa+icon-1320162799182509645.png" alt="">
                                                       </label>
                                                   </div>
                                               </div>
                                               <div class="col-md-3">
                                                   <div class="form-check">
                                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                       <label class="form-check-label" for="flexCheckDefault">
                                                           <img class=" w-50px" src="public/assets/img/Master-Card-Blue-icon.png" alt="">
                                                       </label>
                                                   </div>
                                               </div>
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
