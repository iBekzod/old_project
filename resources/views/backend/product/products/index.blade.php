@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All products')}}</h1>
            </div>
            {{-- @if($type != 'Seller')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('products.create') }}" class="btn btn-circle btn-info">
                        <span>{{translate('Add New Product')}}</span>
                    </a>
                </div>
            @endif --}}
        </div>
    </div>
    <br>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Product') }}</h5>
                </div>
                @if($type == 'Seller')
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                                name="user_id" onchange="sort_products()">
                            <option value="">{{ translate('All Sellers') }}</option>
                            @foreach (App\Seller::all() as $key => $seller)
                                @if ($seller->user != null && $seller->user->shop != null)
                                    <option value="{{ $seller->user->id }}"
                                            @if ($seller->user->id == $seller_id) selected @endif>{{ $seller->user->shop->name }}
                                        ({{ $seller->user->name }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif
                @if($type == 'All')
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                                name="user_id" onchange="sort_products()">
                            <option value="">{{ translate('All Sellers') }}</option>
                            @foreach (App\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                                <option value="{{ $seller->id }}"
                                        @if ($seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-2 ml-auto">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="type" id="type"
                            onchange="sort_products()">
                        <option value="">{{ translate('Sort By') }}</option>
                        <option value="rating,desc"
                                @isset($col_name , $query) @if($col_name == 'rating' && $query == 'desc') selected @endif @endisset>{{translate('Rating (High > Low)')}}</option>
                        <option value="rating,asc"
                                @isset($col_name , $query) @if($col_name == 'rating' && $query == 'asc') selected @endif @endisset>{{translate('Rating (Low > High)')}}</option>
                        <option value="num_of_sale,desc"
                                @isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'desc') selected @endif @endisset>{{translate('Num of Sale (High > Low)')}}</option>
                        <option value="num_of_sale,asc"
                                @isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'asc') selected @endif @endisset>{{translate('Num of Sale (Low > High)')}}</option>
                       {{--   <option value="price,desc"
{{--                                @isset($col_name , $query) @if($col_name == 'price' && $query == 'desc') selected @endif @endisset>{{translate('Base Price (High > Low)')}}</option>                        <option value="price,asc"
{{--                                @isset($col_name , $query) @if($col_name == 'price' && $query == 'asc') selected @endif @endisset>{{translate('Base Price (Low > High)')}}</option> --}}
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                               @isset($sort_search) value="{{ $sort_search }}"
                               @endisset placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>
            </form>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{translate('Name')}}</th>
                        @if($type == 'Seller' || $type == 'All')
                            <th>{{translate('Added By')}}</th>
                        @endif
                        <th>{{translate('Num of Sale')}}</th>
                        <th>{{translate('Total Stock')}}</th>
                        <th>{{translate('Base Price')}}</th>
                       {{-- <th>{{translate('Currency')}}</th> --}}
                        <th>{{translate('Rating')}}</th>
                        {{-- <th>{{translate('Todays Deal')}}</th>

                        <th>{{translate('Published')}}</th>
                        <th>{{translate('Featured')}}</th> --}}
                        <th class="text-right">{{translate('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    @dd($products)--}}
                    @foreach($products as $key => $product)
                        <tr>
                            <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                            <td>
                                <a href="{{ url('single_product/'.$product->slug) }}" target="_blank">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <img src="{{ ($product->variation)?uploaded_asset($product->variation->thumbnail_img)??static_asset('assets/img/placeholder.jpg'):null}}" alt="Image"
                                                    class="w-50px">
                                        </div>
                                        <div class="col-lg-8">
                                            <span class="text-muted">{{  ($product->variation)?$product->variation->getTranslation('name'):null}}</span>
                                        </div>
                                        @if($product->on_moderation)
                                            <span class="badge badge-pill badge-info">{{translate('new')}}</span>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            @if($type == 'Seller' || $type == 'All')
                                <td>{{ ($product)?$product->user->name??null:null }}</td>
                            @endif
                            <td>{{ $product->num_of_sale??0 }} {{translate('times')}}</td>
                            <td>
                                {{($product)?$product->qty??0:null}}
                            </td>
                            <td>{{ ($product)?number_format(homeBasePrice($product->id), 2):null }}</td>
                            {{-- <td>{{ $product->currency->code }}</td> --}}
                            <td>{{ $product->rating??0 }}</td>
                            {{-- <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_todays_deal(this)" value="{{ $product->id }}"
                                           type="checkbox" @if(($product)?$product->todays_deal:null == 1) checked @endif >
                                    <span class="slider round"></span>
                                </label>
                            </td>

                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}"
                                           type="checkbox" @if(($product)?$product->published:null == 1) checked @endif >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}"
                                           type="checkbox" @if(($product)?$product->featured:null == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </td> --}}
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{route('element.products.edit', ['id'=>$product->element->id] )}}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                   data-href="{{route('products.destroy', ['id'=>$product->id])}}"
                                   title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $products->appends(request()->input())->links() }}
                </div>
            </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
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
            $.post('{{ route('products.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
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
            $.post('{{ route('products.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_products(el) {
            $('#sort_products').submit();
        }
        let newValue = '';
        function onChange(e) {
            newValue = e.target.value;
            document.querySelector("#change").value = newValue;
        }

    </script>
@endsection
