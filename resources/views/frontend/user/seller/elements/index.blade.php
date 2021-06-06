@extends('frontend.layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="mt-2 mb-3 text-left aiz-titlebar">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('All elements') }}</h1>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <a href="{{ route('seller.elements.create') }}" class="btn btn-circle btn-info">
                                    <span>{{ translate('Add New Element') }}</span>
                                </a>
                                <a href="{{ route('seller.elements.clone') }}" class="btn btn-circle btn-info">
                                    <span>{{ translate('Clone Element') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="card">
                        <form class="" id="sort_elements" action="" method="GET">
                            <div class="card-header row gutters-5">
                                <div class="text-center col text-md-left">
                                    <h5 class="mb-md-0 h6">{{ translate('All Element') }}</h5>
                                </div>
                                @if ($type == 'Seller')
                                    <div class="ml-auto col-md-2">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0"
                                            id="user_id" name="user_id" onchange="sort_elements()">
                                            <option value="">{{ translate('All Sellers') }}</option>
                                            @foreach (App\Seller::all() as $key => $seller)
                                                @if ($seller->user != null && $seller->user->shop != null)
                                                    <option value="{{ $seller->user->id }}" @if ($seller->user->id == $seller_id) selected @endif>{{ $seller->user->shop->name }}
                                                        ({{ $seller->user->name }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if ($type == 'All')
                                    <div class="ml-auto col-md-2">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0"
                                            id="user_id" name="user_id" onchange="sort_elements()">
                                            <option value="">{{ translate('All Sellers') }}</option>
                                            @foreach (App\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                                                <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="ml-auto col-md-2">
                                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" name="type"
                                        id="type" onchange="sort_elements()">
                                        <option value="">{{ translate('Sort By') }}</option>
                                        <option value="rating,desc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'desc') selected @endif @endisset>{{ translate('Rating (High > Low)') }}</option>
                                        <option value="rating,asc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'asc') selected @endif @endisset>{{ translate('Rating (Low > High)') }}</option>
                                        {{-- <option value="num_of_sale,desc"
                                @isset($col_name, $query) @if ($col_name == 'num_of_sale' && $query == 'desc') selected @endif @endisset>{{translate('Num of Sale (High > Low)')}}</option>
                        <option value="num_of_sale,asc"
                                @isset($col_name, $query) @if ($col_name == 'num_of_sale' && $query == 'asc') selected @endif @endisset>{{translate('Num of Sale (Low > High)')}}</option>
                        <option value="unit_price,desc"
                                @isset($col_name, $query) @if ($col_name == 'unit_price' && $query == 'desc') selected @endif @endisset>{{translate('Base Price (High > Low)')}}</option>
                        <option value="unit_price,asc"
                                @isset($col_name, $query) @if ($col_name == 'unit_price' && $query == 'asc') selected @endif @endisset>{{translate('Base Price (Low > High)')}}</option> --}}
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-0 form-group">
                                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                                            placeholder="{{ translate('Type & Enter') }}">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body">
                            <table class="table mb-0 aiz-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="20%">{{ translate('Name') }}</th>
                                        @if ($type == 'Seller' || $type == 'All')
                                            <th>{{ translate('Added By') }}</th>
                                        @endif
                                        {{-- <th>{{translate('Num of Sale')}}</th>
                        <th>{{translate('Total Stock')}}</th>
                        <th>{{translate('Base Price')}}</th> --}}
                                        {{-- <th>{{ translate('Todays Deal') }}</th> --}}
                                        <th>{{ translate('Rating') }}</th>
                                        {{-- <th>{{ translate('Published') }}</th> --}}
                                        <th>{{ translate('Featured') }}</th>
                                        <th class="text-right">{{ translate('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($elements as $key => $element)
                                        <tr>
                                            <td>{{ $key + 1 + ($elements->currentPage() - 1) * $elements->perPage() }}</td>
                                            <td>
                                                {{-- <a href="{{ route('seller.element', $element->slug) }}" target="_blank"> --}}
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <img src="{{ uploaded_asset($element->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                                                            alt="Image" class="w-50px">
                                                    </div>
                                                    <div class="col-lg-8">
                                                        {{-- <span class="text-muted">{{ $element->getTranslation('name') }}</span> --}}
                                                        <span class="text-muted">{{ $element->name }}</span>
                                                    </div>
                                                </div>
                                                {{-- </a> --}}
                                            </td>
                                            @if ($type == 'Seller' || $type == 'All')
                                                <td>{{ $element->user->name }}</td>
                                            @endif
                                            {{-- <td>{{ $element->num_of_sale }} {{translate('times')}}</td>
                            <td>
                                @php
                                    $qty = 0;
                                    if($element->variant_element){
                                        foreach ($element->stocks as $key => $stock) {
                                            $qty += $stock->qty;
                                        }
                                    }
                                    else{
                                        $qty = $element->current_stock;
                                    }
                                    echo $qty;
                                @endphp
                            </td>
                            <td>{{ number_format($element->unit_price,2) }}</td> --}}
                                            <td>{{ $element->rating }}</td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success">
                                                    <input onchange="update_featured(this)" value="{{ $element->id }}"
                                                        type="checkbox" <?php if ($element->featured == 1) {
                                                    echo 'checked';
                                                    } ?> >
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="text-right">

                                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    href="{{ route('seller.elements.edit', ['id' => $element->id, 'lang' => default_language()]) }}"
                                                    title="{{ translate('Edit') }}">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <a href="#"
                                                    class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                    data-href="{{ route('seller.elements.destroy', $element->id) }}"
                                                    title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </a>

                                                <a href="{{ route('seller.elements.products.edit', ['id' => $element->id]) }}"
                                                    class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    title="{{ translate('Products') }}">
                                                    <i class="las la-clipboard-list"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{ $elements->appends(request()->input())->links() }}
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
    <script type="text/javascript">
        $(document).ready(function() {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('seller.elements.todays_deal') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Todays Deal updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('seller.elements.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published elements updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('seller.elements.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured elements updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_elements(el) {
            $('#sort_elements').submit();
        }

    </script>
@endsection
