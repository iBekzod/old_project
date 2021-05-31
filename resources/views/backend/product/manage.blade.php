@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('Manage Products')}}</h1>
            </div>
        </div>
    </div>
    <br>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Manage Products') }}</h5>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                <tr>
                    <th>#</th>
                    <th width="20%">{{translate('Name')}}</th>
                    <th>{{translate('Added By')}}</th>
                    <th>{{translate('Num of Sale')}}</th>
                    <th>{{translate('Total Stock')}}</th>
                    <th>{{translate('Base Price')}}</th>
                    <th>{{translate('Published')}}</th>
                    <th>{{translate('Featured')}}</th>
                    <th class="text-right">{{translate('Accepted')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td>{{ ($key+1) + ($products->currentPage() - 1)*$products->perPage() }}</td>
                        <td>
                            <a href="{{ route('product', $product->slug) }}" target="_blank">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <img src="{{ uploaded_asset($product->thumbnail_img)??static_asset('assets/img/placeholder.jpg')}}" alt="Image"
                                             class="w-50px">
                                    </div>
                                    <div class="col-md-8">
                                        <span class="text-muted">{{ $product->getTranslation('name') }}</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $product->user->name }}</td>
                        <td>{{ $product->num_of_sale }} {{translate('times')}}</td>
                        <td>
                            {{$product->qty}}
                        </td>
                        <td>{{ number_format($product->unit_price,2) }}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_published(this)" value="{{ $product->id }}"
                                       type="checkbox" <?php if ($product->published == 1) echo "checked";?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_featured(this)" value="{{ $product->id }}"
                                       type="checkbox" <?php if ($product->featured == 1) echo "checked";?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="text-right">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_accepted(this)" value="{{ $product->id }}"
                                       type="checkbox" @if($product->is_accepted == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                            {{-- <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                               href="{{ route('products.manage.change.accept', $product->id) }}"
                               title="{{ translate('Accept') }}">
                                <i class="las la-check"></i>
                            </a>
                            <a class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                               href="{{ route('products.manage.change.refuse', $product->id) }}"
                               title="{{ translate('Cancel') }}">
                                <i class="las la-times"></i>
                            </a> --}}

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

        function update_accepted(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.accepted') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Accepted products updated successfully') }}');
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

    </script>

@endsection
