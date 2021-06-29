@extends('backend.layouts.app')

@section('content')
    <div class="mt-1 mb-1 text-left aiz-titlebar">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{translate('All elements')}}</h1>
            </div>
            @if($type != 'Seller')
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('elements.create') }}" class="btn btn-circle btn-info">
                        <span>{{translate('Add New Element')}}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_elements" action="" method="GET">
            <div class="card-header row gutters-5">
                {{-- <div class="my-1 ml-auto col-md-2">
                    <div class="text-center col text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Elements') }}</h5>
                    </div>
                </div> --}}
                <div class="my-2 ml-auto col-md-8">
                    <div class="mb-0 text-center form-group col text-md-right">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"  onchange="sort_elements()"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
                <div class="my-2 ml-auto col-md-2">
                    <div class="mb-0 text-center form-group col text-md-right">
                        <select class="form-control form-control-sm aiz-selectpicker" name="type" id="type"
                                onchange="sort_elements()">
                            <option value="">{{ translate('Sort By') }}</option>
                            <option value="rating,desc"
                                    @isset($col_name , $query) @if($col_name == 'rating' && $query == 'desc') selected @endif @endisset>{{translate('Rating (High > Low)')}}</option>
                            <option value="rating,asc"
                                    @isset($col_name , $query) @if($col_name == 'rating' && $query == 'asc') selected @endif @endisset>{{translate('Rating (Low > High)')}}</option>
                            {{-- <option value="num_of_sale,desc"
                                    @isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'desc') selected @endif @endisset>{{translate('Num of Sale (High > Low)')}}</option>
                            <option value="num_of_sale,asc"
                                    @isset($col_name , $query) @if($col_name == 'num_of_sale' && $query == 'asc') selected @endif @endisset>{{translate('Num of Sale (Low > High)')}}</option>
                            <option value="unit_price,desc"
                                    @isset($col_name , $query) @if($col_name == 'unit_price' && $query == 'desc') selected @endif @endisset>{{translate('Base Price (High > Low)')}}</option>
                            <option value="unit_price,asc"
                                    @isset($col_name , $query) @if($col_name == 'unit_price' && $query == 'asc') selected @endif @endisset>{{translate('Base Price (Low > High)')}}</option> --}}
                        </select>
                    </div>
                </div>
                <div class="my-2 ml-auto col-md-2">
                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" id="user_id"
                            name="user_id" onchange="sort_elements()">
                        <option value="">{{ translate('All Sellers') }}</option>
                        @foreach (App\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                            <option value="{{ $seller->id }}"  @if(isset($seller_id) && $seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-auto col-md-4">
                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                        id="category_id" name="category_id" onchange="sort_elements()">
                        <option value="0" @if($category_id == 0) selected @endif>{{ translate('All categories') }}</option>
                        @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}" @if ($category->id == $category_id) selected @endif>
                                    {{ $category->getTranslation('name', $lang) }}
                                </option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-auto col-md-4">
                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                        id="sub_category_id" name="sub_category_id" onchange="sort_elements()">
                        <option value="0"  @if($sub_category_id == 0) selected @endif>{{ translate('All sub categories') }}</option>
                        @foreach ($sub_categories as $key => $category)
                                <option value="{{ $category->id }}" @if ($category->id == $sub_category_id) selected @endif>
                                    {{ $category->getTranslation('name', $lang) }}
                                </option>
                        @endforeach
                    </select>
                </div>
                <div class="ml-auto col-md-4">
                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" data-live-search="true"
                        id="sub_sub_category_id" name="sub_sub_category_id" onchange="sort_elements()">
                        <option value="0"  @if($sub_sub_category_id == 0) selected @endif>{{ translate('All sub sub categories') }}</option>
                        @foreach ($sub_sub_categories as $key => $category)
                                <option value="{{ $category->id }}" @if ($category->id == $sub_sub_category_id) selected @endif>
                                    {{ $category->getTranslation('name', $lang) }}
                                </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table mb-0 aiz-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{ translate('Name') }}</th>
                        <th>{{translate('Todays Deal')}}</th>
                        <th>{{translate('Rating')}}</th>
                        <th>{{translate('Published')}}</th>
                        <th>{{translate('Featured')}}</th>
                        {{-- <th width="60%">{{ translate('Description') }}</th> --}}
                        <th>{{ translate('Added By') }}</th>
                        {{-- <th>{{ translate('Is cloned') }}</th> --}}
                        <th class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($elements as $key => $element)
                        <tr>
                            <td>{{ $key + 1 + ($elements->currentPage() - 1) * $elements->perPage() }}</td>
                            <td>
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <img src="{{ uploaded_asset($element->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                                            alt="Image" class="w-50px">
                                    </div>
                                    <div class="col-lg-8">
                                        <span class="text-muted">{{ $element->getTranslation('name') }}</span>
                                        {{-- <span class="text-muted">{{ $element->name }}</span> --}}
                                    </div>
                                </div>
                            </td>
                            {{-- <td>{!! strip_tags($element->getTranslation('description')) !!}</td> --}}
                            <td>
                                <label class="mb-0 aiz-switch aiz-switch-success">
                                    <input onchange="update_todays_deal(this)" value="{{ $element->id }}"
                                           type="checkbox" <?php if ($element->todays_deal == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{{ $element->rating }}</td>
                            <td>
                                <label class="mb-0 aiz-switch aiz-switch-success">
                                    <input onchange="update_published(this)" value="{{ $element->id }}"
                                           type="checkbox" <?php if ($element->published == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="mb-0 aiz-switch aiz-switch-success">
                                    <input onchange="update_featured(this)" value="{{ $element->id }}"
                                           type="checkbox" <?php if ($element->featured == 1) echo "checked";?> >
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>{{ $element->user->name }}</td>
                            {{-- <td class="text-right">
                                <label class="mb-0 aiz-switch aiz-switch-success">
                                    <input disabled onchange="clone_selected(this)" value="{{ $element->id }}"
                                           type="checkbox" @if($element->cloned == true) checked @endif >
                                    <span class="slider round"></span>
                                </label>
                            </td> --}}
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('elements.admin.edit', ['id'=>$element->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}"
                                       title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                <a href="{{route('element.products.edit', ['id'=>$element->id])}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm"
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
@endsection


@section('script')
    <script type="text/javascript">
        function update_todays_deal(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('elements.todays_deal') }}', {
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
            $.post('{{ route('elements.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
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
            $.post('{{ route('elements.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
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
