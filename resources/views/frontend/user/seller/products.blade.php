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
                                <h1 class="h3">{{ translate('Products') }}</h1>
                            </div>
                        </div>
                    </div>

                    <div class="row gutters-10 justify-content-center">
                        @if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)
                            <div class="mx-auto mb-3 col-md-4">
                                <div class="overflow-hidden text-white rounded-lg bg-grad-1">
                                    <span
                                        class="mx-auto mt-3 size-30px rounded-circle bg-soft-primary d-flex align-items-center justify-content-center">
                                        <i class="text-white las la-upload la-2x"></i>
                                    </span>
                                    <div class="px-3 pt-3 pb-3">
                                        <div class="text-center h4 fw-700">
                                            {{ max(0, Auth::user()->seller->remaining_uploads) }}</div>
                                        <div class="text-center opacity-50">{{ translate('Remaining Uploads') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mx-auto mb-3 col-md-4">
                            <a href="{{ route('seller.products.upload') }}">
                                <div
                                    class="p-3 mb-3 text-center bg-white rounded shadow-sm c-pointer hov-shadow-lg has-transition">
                                    <span
                                        class="mx-auto mb-3 size-60px rounded-circle bg-secondary d-flex align-items-center justify-content-center">
                                        <i class="text-white las la-plus la-3x"></i>
                                    </span>
                                    <div class="fs-18 text-primary">{{ translate('Add New Product') }}</div>
                                </div>
                            </a>
                        </div>

                        @if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated)
                            @php
                                $seller_package = \App\SellerPackage::find(Auth::user()->seller->seller_package_id);
                            @endphp
                            <div class="col-md-4">
                                <a href="{{ route('seller_packages_list') }}"
                                    class="p-3 text-center bg-white rounded shadow-sm hov-shadow-lg d-block">
                                    @if ($seller_package != null)
                                        <img src="{{ uploaded_asset($seller_package->logo) ?? static_asset('assets/img/placeholder.jpg') }}"
                                            height="44" class="mx-auto mw-100">
                                        <span class="mb-2 d-block sub-title">{{ translate('Current Package') }}:
                                            {{ $seller_package->getTranslation('name') }}</span>
                                    @else
                                        <i class="mb-2 la la-frown-o la-3x"></i>
                                        <div class="mb-2 d-block sub-title">{{ translate('No Package Found') }}</div>
                                    @endif
                                    <div class="py-1 btn btn-outline-primary">{{ translate('Upgrade Package') }}</div>
                                </a>
                            </div>
                        @endif

                    </div>

                    {{-- <div class="card">
                        <div class="card-header">
                            <a href="{{ route('seller.products.clone')}}" class="btn btn-primary d-inline-block">{{ translate('Clone Product')}}</a>
                        </div>
                    </div> --}}

                    <div class="card">
                        <div class="card-header row gutters-5">
                            <div class="col">
                                <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <form class="" action="" method="GET">
                                        <input type="text" class="form-control" id="search" name="search" @isset($search)
                                            value="{{ $search }}" @endisset
                                            placeholder="{{ translate('Search product') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table mb-0 aiz-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="30%">{{ translate('Name') }}</th>
                                        <th data-breakpoints="md">{{ translate('Category') }}</th>
                                        <th data-breakpoints="md">{{ translate('Current Qty') }}</th>
                                        <th>{{ translate('Base Price') }}</th>
                                        <th data-breakpoints="md">{{ translate('Published') }}</th>
                                        <th data-breakpoints="md" class="text-right">{{ translate('Options') }}</th>
                                        <th data-breakpoints="md" class="text-right">{{ translate('Is Accepted?') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                            <td>
                                                <a href="{{ route('product', $product->slug) }}" target="_blank"
                                                    class="text-reset">
                                                    {{ $product->getTranslation('name') }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($product->category != null)
                                                    {{ $product->category->getTranslation('name') }}
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $qty = 0;
                                                    if ($product->variant_product) {
                                                        foreach ($product->stocks as $key => $stock) {
                                                            $qty += $stock->qty;
                                                        }
                                                    } else {
                                                        $qty = $product->current_stock;
                                                    }
                                                    echo $qty;
                                                @endphp
                                            </td>
                                            <td>{{ $product->unit_price }}</td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success">
                                                    <input onchange="update_published(this)" value="{{ $product->id }}"
                                                        type="checkbox" <?php if ($product->published == 1) {
                                                    echo 'checked';
                                                    } ?> >
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="text-right">
                                                {{-- <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('seller.products.characteristics', ['id'=>$product->id])}}" title="{{ translate('Characteristics') }}">
                                                    <i class="las la-list"></i>
                                                </a> --}}
                                                {{-- <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{route('seller.products.edit', ['id'=>$product->id, 'lang'=default_language()])}}" title="{{ translate('Edit') }}"> --}}
                                                <i class="las la-edit"></i>
                                                </a>
                                                {{-- <a href="{{route('products.duplicate', $product->id)}}" class="btn btn-soft-success btn-icon btn-circle btn-sm"  title="{{ translate('Duplicate') }}">
                    							   <i class="las la-copy"></i>
                    						  </a> --}}
                                                <a href="#"
                                                    class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                    data-href="{{ route('products.destroy', $product->id) }}"
                                                    title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($product->is_accepted)
                                                    <span><i class="las la-check"></i></span>
                                                @else
                                                    <span><i class="las la-times"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{ $products->links() }}
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
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.seller.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
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
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
