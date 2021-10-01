
<div class="modal-header py-2">
    <h6 class="modal-title strong-600 heading-5">{{ translate('Order id')}}: {{ $order->code }}</h6>
     <span><b>Callcenter:</b>+998975644455</span>
    <button type="button" data-dismiss="modal" aria-label="Close" style="border: none">
            <img src="{{ static_asset('assets/img/logo.png') }}" height="30" style="display:inline-block;">
    </button>
</div>

@php
    $status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->delivery_status;
    $payment_status = $order->orderDetails->where('seller_id', Auth::user()->id)->first()->payment_status;
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
@endphp

<div class="modal-body gry-bg px-3 pt-0">
    <div class="pt-1">
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
    </div>
    @if (get_setting('product_manage_by_admin') == 0)
        <div class="row mt-2">
            @if($order->payment_type == 'cash_on_delivery')
                <div class="offset-lg-2 col-lg-4 col-sm-6">
                    <div class="form-group">
                        <select class="form-control aiz-selectpicker form-control-sm"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                            <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{ translate('Unpaid')}}</option>
                            <option value="paid" @if ($payment_status == 'paid') selected @endif>{{ translate('Paid')}}</option>
                        </select>
                        <label>{{ translate('Payment Status')}}</label>
                    </div>
                </div>
            @endif
            <div class="col-lg-4 col-sm-6">
                <div class="form-group">
                    <select class="form-control aiz-selectpicker form-control-sm"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" @if ($status == 'pending') selected @endif>{{ translate('Pending')}}</option>
                        <option value="confirmed" @if ($status == 'confirmed') selected @endif>{{ translate('Confirmed')}}</option>
                        <option value="on_delivery" @if ($status == 'on_delivery') selected @endif>{{ translate('On delivery')}}</option>
                        <option value="delivered" @if ($status == 'delivered') selected @endif>{{ translate('Delivered')}}</option>
                    </select>
                    <label>{{ translate('Delivery Status')}}</label>
                </div>
            </div>
        </div>
    @endif



    <div class="row">
        <div class="col-md-2">
           <p>
                <b>{{ translate('Order Code')}}:</b><br>
                <b>{{ translate('Customer')}}:</b><br>
                <b>{{ translate('Email')}}:</b><br>
                <b>{{ translate('Shipping address')}}:</b><br>
           </p>
        </div>
        <div class="col-md-3">
         <p>
             <span>{{ $order->code }}</span><br>
             <span>{{ json_decode($order->shipping_address)->name }}</span><br>
             <span>{{ $order->user->email }}</span><br>
             <span>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->postal_code }}, {{ json_decode($order->shipping_address)->country }}</span><br>
         </p>
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-2">
            <p>
                <b>{{ translate('Order date')}}:</b><br>
                <b>{{ translate('Order status')}}:</b><br>
                <b>{{ translate('Total order amount')}}:</b><br>
                <b>{{ translate('Payment method')}}:</b><br>
           </p>

        </div>
        <div class="col-md-2">
            <p>
                <span>{{ date('d-m-Y H:i A', $order->date) }}</span><br>
                <span class="badge badge-inline badge-success">{{ translate($status)}}</span><br>
                <span>{{ single_price($order->grand_total) }}</span><br>
                {{-- <span>{{ json_decode($order->shipping_address)->phone }}</span><br> --}}
                <span>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</span><br>

            </p>
        </div>
    </div>



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
                            @foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    @if ($orderDetail->product != null)
                                        <td>
                                            {{-- {{ $orderDetail->product }} --}}
                                            <img src="{{ uploaded_asset($orderDetail->product->variation->thumbnail_img) }}" alt="Image" class="size-25px">

                                        </td>
                                        <td style="size: 5px">
                                            {{-- <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a> --}}
                                            {{ $orderDetail->product->getTranslation('name') }}
                                            @else
                                                <strong>{{  translate('Product Unavailable') }}</strong>
                                        </td>

                                    @endif

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
                                    <td>
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

        <div class="row">
            <div class="col-lg-9"></div>
            <div class="col-lg-3">
                <div class="card m-0 p-0">
                    <table class="table m-0 p-0">
                        <tbody>
                            <tr>
                                <td><b>{{ translate('Subtotal')}}</b></th>
                                <td class="text-right">
                                    <span >{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ translate('Shipping')}}</b></th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('shipping_cost')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ translate('Tax')}}</b></th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ translate('Coupon')}}</b></th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b>{{ translate('Total')}}</b></th>
                                <td class="text-right">
                                    <strong>
                                        <span>{{ single_price($order->grand_total) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $('#update_delivery_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_delivery_status').val();
        $.post('{{ route('orders.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
            $('#order_details').modal('hide');
            AIZ.plugins.notify('success', '{{ translate('Order status has been updated') }}');
            location.reload().setTimeOut(500);
        });
    });

    $('#update_payment_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_payment_status').val();
        $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
            $('#order_details').modal('hide');
            //console.log(data);
            AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            location.reload().setTimeOut(500);
        });
    });
</script>
