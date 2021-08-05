@extends('frontend.layouts.app')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="mt-2 mb-4 aiz-titlebar">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Delivery metrics') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{translate('Delivery Cost per kg')}}</h5>
                                </div>
                                <form action="{{ route('seller.seller_configuration.update') }}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <input type="hidden" name="type" value="kg_weight_price">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" name="kg_weight_price" value="{{ \App\SellerSetting::where('type', 'kg_weight_price')->where('user_id', auth()->id())->first()->value??\App\SellerSetting::where('type', 'kg_weight_price')->first()->value }}">
                                            @php
                                                $weitght_relation_id=\App\SellerSetting::where('type', 'kg_weight_price')->where('user_id', auth()->id())->first()->relation_id??\App\SellerSetting::where('type', 'kg_weight_price')->first()->relation_id;
                                            @endphp
                                            <select class="form-control aiz-selectpicker"  name="relation_id" onchange="change_selection(this.value, 'currency_change')" >
                                                @foreach(\App\Currency::all() as $currency)
                                                    <option  value="{{$currency->id}}" @if($currency->id==$weitght_relation_id) selected @endif>{{$currency->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-0 text-right form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{translate('Express percent')}}</h5>
                                </div>
                                <form action="{{ route('seller.seller_configuration.update') }}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <input type="hidden" name="type" value="express_percent">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" name="express_percent" value="{{ \App\SellerSetting::where('type', 'express_percent')->where('user_id', auth()->id())->first()->value??\App\SellerSetting::where('type', 'express_percent')->first()->value }}">
                                        </div>
                                    </div>
                                    <div class="mb-0 text-right form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{translate('Express distance')}}</h5>
                                </div>
                                <form action="{{ route('seller.seller_configuration.update') }}" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <input type="hidden" name="type" value="express_distance">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" name="express_distance" value="{{ \App\SellerSetting::where('type', 'express_distance')->where('user_id', auth()->id())->first()->value??\App\SellerSetting::where('type', 'express_distance')->first()->value }}">
                                        </div>
                                    </div>
                                    <div class="mb-0 text-right form-group">
                                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Add New deliveries') }}</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('deliveries.store') }}" method="POST">
                                        @method("POST")
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3 form-group">
                                                    <label for="name">{{ translate('To Distance (km)') }}</label>
                                                    <input type="number" min="0" step="0.01" placeholder="{{ translate('Distance (km)') }}"
                                                        name="distance" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 form-group">
                                                    <label for="name">{{ translate('Cost per km (sums)') }}</label>
                                                    <input type="number" min="0" step="0.01" placeholder="{{ translate('Cost per km (sums)') }}"
                                                        name="price" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3 form-group">
                                                    <label for="name">{{ translate('Duration (days)') }}</label>
                                                    <input type="number" min="0" step="1" placeholder="{{ translate('in days') }}"
                                                        name="days" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mt-4 text-right form-group">
                                                    <button type="submit" class="btn btn-primary">{{ translate('Add') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table mb-0 aiz-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ translate('To Distance (km)') }}</th>
                                                <th>{{ translate('Cost per km (sums)') }}</th>
                                                <th>{{ translate('Duration (days)') }}</th>
                                                <th class="text-right">{{ translate('Options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deliveries as $key => $delivery)
                                                <tr>
                                                    <td>{{ $key + 1 + ($deliveries->currentPage() - 1) * $deliveries->perPage() }}</td>
                                                    <td>{{ $delivery->distance }}</td>
                                                    <td>{{ $delivery->price }}</td>
                                                    <td>{{ $delivery->days }}</td>
                                                    <td class="text-right">
                                                        {{-- <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                            href="{{ route('deliveries.edit', ['delivery' => $delivery->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                                            title="{{ translate('Edit') }}">
                                                            <i class="las la-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                            data-href="{{ route('deliveries.destroy', $delivery->id) }}"
                                                            title="{{ translate('Delete') }}">
                                                            <i class="las la-trash"></i>
                                                        </a> --}}

                                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                                            title="{{ translate('Edit') }}" data-toggle="modal"
                                                            data-target="#EditModal_{{ $delivery->id }}">
                                                            <i class="las la-edit"></i>
                                                        </a>

                                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                            data-href="{{ route('deliveries.destroy', $delivery->id) }}"
                                                            title="{{ translate('Delete') }}">
                                                            <i class="las la-trash"></i>
                                                        </a>

                                                        <form class="p-4" action="{{ route('deliveries.update', $delivery->id) }}"
                                                            method="POST">
                                                            <div class="overflow-hidden modal fade" id="EditModal_{{ $delivery->id }}"
                                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">
                                                                                {{ translate('Attribute Information') }}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3 form-group row">
                                                                                <label for="name">{{ translate('Name') }}<i
                                                                                        class="las la-language text-danger"
                                                                                        title="{{ translate('Translatable') }}"></i></label>
                                                                                <input type="text" placeholder="{{ translate('Name') }}"
                                                                                    name="name" class="form-control" required
                                                                                    value="{{ $delivery->getTranslation('name') }}">
                                                                            </div>
                                                                            <div class="mb-3 form-group row">
                                                                                <label
                                                                                    for="edit_branch_attribute_{{ $delivery->id }}">{{ translate('Branch') }}</label>
                                                                                <select class="form-control"
                                                                                    name="edit_branch_attribute_{{ $delivery->id }}"
                                                                                    {{-- id="edit_branch_{{$delivery->id}}" --}} data-live-search="true" required>
                                                                                    @foreach ($branches as $item)
                                                                                        <option @if (isset($branch) && $item->id == $branch->id) selected @endif
                                                                                            value="{{ $item->id }}">
                                                                                            {{ $item->getTranslation('name') }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">{{ translate('Close') }}</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">{{ translate('Save') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{ $deliveries->appends(request()->input())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    {{-- <script type="text/javascript">
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
        }

    </script> --}}
@endsection
