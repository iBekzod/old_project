@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
    </div>
    <div class="card-body">

        @php
        $delivery_status = $order->delivery_status;
        $payment_status = $order->payment_status;
        @endphp
       @php
       $status = $order->delivery_status;
       $payment_status = $order->payment_status;
       $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
       @endphp


        <div class="row gutters-5 text-center aiz-steps">
            <div class="col @if($status == 'pending') active @else done @endif">
                <div class="icon mb-0">
                    <i class="las la-file-invoice"></i>
                </div>
                <div class="title fs-12">{{ translate('Order placed')}}</div>
            </div>
            <div class="col @if($status == 'confirmed') active @elseif($status == 'on_delivery' || $status == 'delivered') done @endif">
                <div class="icon  mb-0">
                    <i class="las la-newspaper"></i>
                </div>
              <div class="title fs-12">{{ translate('Confirmed')}}</div>
            </div>
            <div class="col @if($status == 'on_delivery') active @elseif($status == 'delivered') done @endif">
                <div class="icon mb-0">
                    <i class="las la-truck"></i>
                </div>
                <div class="title fs-12">{{ translate('On delivery')}}</div>
            </div>
            <div class="col @if($status == 'delivered') done @endif">
                <div class="icon mb-0">
                    <i class="las la-clipboard-check"></i>
                </div>
                <div class="title fs-12">{{ translate('Delivered')}}</div>
            </div>
        </div>
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
            </div>

        {{-- @php
        $status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->delivery_status;
        $payment_status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->payment_status;
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
        @endphp --}}
            <!--Assign Delivery Boy-->

            @if (\App\Addon::where('unique_identifier', 'delivery_boy')->first() != null &&
                \App\Addon::where('unique_identifier', 'delivery_boy')->first()->activated)

                <div class="col-md-3 ml-auto">
                    <label for="assign_deliver_boy">{{translate('Assign Deliver Boy')}}</label>
                    @if($delivery_status == 'pending' || $delivery_status == 'picked_up')
                    <select class="form-control aiz-selectpicker" data-live-search="true" data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                        <option value="">{{translate('Select Delivery Boy')}}</option>
                        @foreach($delivery_boys as $delivery_boy)
                        <option value="{{ $delivery_boy->id }}" @if($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                            {{ $delivery_boy->name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                        <input type="text" class="form-control" value="{{ optional($order->delivery_boy)->name }}" disabled>
                    @endif
                </div>
            @endif

            <div class="col-md-3 ml-auto">
                <label for=update_payment_status"">{{translate('Payment Status')}}</label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                    <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{translate('Unpaid')}}</option>
                    <option value="paid" @if ($payment_status == 'paid') selected @endif>{{translate('Paid')}}</option>
                </select>
            </div>
            <div class="col-md-3 ml-auto">
                <label for=update_delivery_status"">{{translate('Delivery Status')}}</label>
                @if($delivery_status != 'delivered' && $delivery_status != 'cancelled')
                    <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                        <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                        <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option>
                        <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>{{translate('On The Way')}}</option>
                        <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option>
                        <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option>
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ $delivery_status }}" disabled>
                @endif
            </div>
        </div>
        {{-- @dd(json_decode($order->shipping_address)) --}}
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
                <address>
                    <strong class="text-main">{{ json_decode($order->shipping_address)->name??null }}</strong><br>
                    {{ json_decode($order->shipping_address)->email??null }}<br>
                    {{ json_decode($order->shipping_address)->phone??null }}<br>
                    {{-- {{ json_decode($order->shipping_address)->address??null }}, {{ json_decode($order->shipping_address)->city??null }}, {{ json_decode($order->shipping_address)->postal_code??null }}<br> --}}
                    {{-- {{ json_decode($order->shipping_address)->country??null }} --}}
                </address>
                @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                <br>
                <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name??null }}, {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount??null) }}, {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id??null }}
                <br>
                <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo??null) }}" target="_blank"><img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo??null) }}" alt="" height="100"></a>
                @endif
            </div>
            <div class="col-md-4 ml-auto">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order #')}}</td>
                            <td class="text-right text-info text-bold">	{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order Status')}}</td>
                            <td class="text-right">
                                @if($delivery_status == 'delivered')
                                <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @else
                                <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Order Date')}}	</td>
                            <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                {{translate('Total amount')}}
                            </td>
                            <td class="text-right">
                                {{ single_price($order->grand_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{translate('Payment method')}}</td>
                            <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="new-section-sm bord-no">

        <div class="row">
            <div class="col-lg-12">
                    <div class="card pb-0">
                        <table class="table table-bordered m-0 text-center">
                            {{-- style="border-collapse: collapse; border:1px solid black" --}}
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Poto')}}</th>
                                    <th width="30%">{{ translate('Product')}}</th>
                                    <th>{{ translate('Option')}}</th>
                                    <th>{{ translate('Shop')}}</th>
                                    <th>{{ translate('Delivery Type')}}</th>
                                    <th>{{ translate('QTY')}}</th>
                                    <th>{{ translate('Price')}}</th>
                                    <th>{{ translate('Total')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        {{-- @if ($orderDetail->product != null) --}}
                                            {{-- <td> --}}
                                                {{-- {{ $orderDetail->product }} --}}
                                                {{-- <img src="{{ uploaded_asset($orderDetail->product->variation->thumbnail_img ?? static_asset('assets/img/placeholder.jpg')) }}" alt="Image" class="size-25px"> --}}
                                                <td><img src="{{ uploaded_asset($orderDetail->product->variation-> thumbnail_img)??static_asset('assets/img/placeholder.jpg') }}" alt="{{translate('Product Image')}}" class="h-25px"></td>
                                            {{-- </td> --}}
                                            <td style="size: 5px">
                                                {{-- <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a> --}}
                                                {{ $orderDetail->product->getTranslation('name') ?? translate('Product Unavailable')}}
                                                {{-- @else --}}
                                            </td>

                                        {{-- @endif --}}

                                        <td>
                                            @if (App\Variation::where('user_id',$orderDetail->seller_id)->exists())
                                            @php
                                            $variation=App\Variation::where('user_id',$orderDetail->seller_id)->first();
                                            $color=App\Color::where('id',$variation->color_id)->first();
                                            $element=App\Element::where('id',$orderDetail->product->element_id)->first();
                                            $brand=App\Brand::where('id',$element->brand_id)->first();

                                            @endphp
                                             <b>Brand:</b><span>
                                                {{ $brand->name }}
                                           </span> <br>
                                             <b> {{ translate('Color') }}:</b><span>
                                                {{ $color->getTranslation('name') }}
                                            </span><br>
                                               @if (App\Characteristic::where('id',$variation->characteristics)->exists())
                                                    @php
                                                    $characteristics=App\Characteristic::where('id',$variation->characteristics)->first();
                                                    $attribute=App\Attribute::where('id',$characteristics->attribute_id)->first();

                                                    @endphp

                                                    <b>Size:</b><span>
                                                        {{ $characteristics->name ?? "" }}
                                                        {{ $attribute->name }}
                                                    </span><br>



                                               @endif

                                            @endif



                                        </td>
                                        <td>
                                            <b>
                                                @php
                                                    $shop=App\Shop::where('user_id',$orderDetail->seller_id)->first();
                                                    echo $shop->name;
                                                @endphp
                                            </b>
                                        </td>
                                        <td
                                            @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                                                {{  translate('Home Delivery') }}
                                            @elseif ($orderDetail->shipping_type == 'pickup_point')
                                                @if ($orderDetail->pickup_point != null)
                                                    {{ $orderDetail->pickup_point->getTranslation('name') }} ({{  translate('Pickip Point') }})
                                                @endif
                                            @elseif ($orderDetail->shipping_type == 'tinfis')
                                             {{  translate('Home Delivery') }}
                                             @elseif ($orderDetail->shipping_type == 'free')
                                             {{  translate('Free') }}
                                            @endif
                                        </td>
                                        <td>
                                            <b>
                                                @if ($orderDetail->product!=null)
                                                  {{ $orderDetail->product->qty }}
                                                @endif
                                             </b>

                                        </td>
                                        <td>
                                          @php
                                              $price=($orderDetail->price)/$orderDetail->product->qty;
                                              echo $price;
                                          @endphp
                                        </td>
                                        {{-- @if ($orderDetail->product!=null &&  )

                                        @endif --}}
                                        <td>
                                            @if ($orderDetail->price!=null)
                                              {{ $orderDetail->price }}
                                            @endif
                                        </td>
                                        {{-- @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                            <td>
                                                @if ($order


                                                translate('Approved') }}</b>
                                                @elseif ($orderDetail->product->refundable != 0)
                                                    <b>{{  translate('N/A') }}</b>
                                                @else
                                                    <b>{{  translate('Non-refundable') }}</b>
                                                @endif
                                            </td>
                                        @endif --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="text-muted">{{translate('Sub Total')}} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('price')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{translate('Tax')}} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('tax')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{translate('Shipping')}} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('shipping_cost')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{translate('Coupon')}} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->coupon_discount) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{translate('TOTAL')}} :</strong>
                            </td>
                            <td class="text-muted h5">
                                {{ single_price($order->grand_total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right no-print">
                    <a href="{{ route('invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function(){
            var order_id = '{{ $order->id }}';
            var delivery_boy = $('#assign_deliver_boy').val();
            // alert(order_id)
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token          :'{{ @csrf_token() }}',
                order_id        :order_id,
                delivery_boy    :delivery_boy
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });

        $('#update_delivery_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token:'{{ @csrf_token() }}',
                order_id:order_id,
                status:status
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });

        $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });
    </script>
@endsection
