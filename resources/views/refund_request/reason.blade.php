@extends('backend.layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Reason For Refund Request') }}</h5>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <b>{{ translate('Order Code') }} : </b>
                        @if ($refund->order != null)
                            {{ $refund->order->code }}
                        @endif
                    </li>
                    <li class="list-group-item">
                        <b>{{ translate('Seller Name') }}  :</b>
                        @if ($refund->seller != null)
                            {{ $refund->seller->name }}
                        @endif
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2">
                                <b> {{ translate('Product name') }}  :</b>
                            </div>
                            <div class="col-md-10">
                                @if ($refund->orderDetail != null && $refund->orderDetail->product != null)
                                    <a href="{{ route('product', $refund->orderDetail->product->slug) }}" target="_blank"
                                        class="media-block">
                                        <div class="row">
                                            <div class="col-auto">
                                                <img src="{{ uploaded_asset($refund->orderDetail->product->variation->thumbnail_img) }}"
                                                    alt="Image" class="size-50px">
                                            </div>
                                            <div class="col">
                                                {{ $refund->orderDetail->product->getTranslation('name') ?? 'product not found' }}
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item mb-2">
                        <b>{{ translate('Price') }} :</b>
                        @if ($refund->orderDetail != null)
                            {{ single_price($refund->orderDetail->price) }}
                        @endif
                    </li>
                    <li class="list-group-item mb-2">
                        <b>{{ translate('Reason') }} :</b>
                        {{ $refund->reason ?? "not found" }}
                    </li>
                    <li class="list-group-item mb-2">
                        <b>{{ translate('Created_at') }} : </b>
                        {{ $refund->created_at ?? "not found" }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
