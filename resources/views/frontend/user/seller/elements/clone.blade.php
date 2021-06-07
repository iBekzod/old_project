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
                                <h1 class="h3">{{ translate('All sample elements') }}</h1>
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
                                    <div class="ml-auto col-md-3">
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
                                {{-- @if ($type == 'All') --}}
                                    <div class="ml-auto col-md-2">
                                        <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0"
                                            id="user_id" name="user_id" onchange="sort_elements()">
                                            <option value="">{{ translate('All Sellers') }}</option>
                                            @foreach (App\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                                                @if($seller->id!=Auth::id())
                                                    <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>{{ $seller->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                {{-- @endif --}}
                                <div class="ml-auto col-md-2">
                                    <select class="mb-2 form-control form-control-sm aiz-selectpicker mb-md-0" name="type"
                                        id="type" onchange="sort_elements()">
                                        <option value="">{{ translate('Sort By') }}</option>
                                        <option value="rating,desc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'desc') selected @endif @endisset>{{ translate('Rating (High > Low)') }}</option>
                                        <option value="rating,asc" @isset($col_name, $query) @if ($col_name == 'rating' && $query == 'asc') selected @endif @endisset>{{ translate('Rating (Low > High)') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
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
                                        <th width="60%">{{ translate('Description') }}</th>
                                        <th>{{ translate('Added By') }}</th>
                                        <th class="text-right">{{ translate('Is cloned') }}</th>
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
                                            <td>{!! strip_tags($element->getTranslation('description')) !!}</td>
                                            <td>{{ $element->user->name }}</td>
                                            <td class="text-right">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input onchange="clone_selected(this)" value="{{ $element->id }}"
                                                           type="checkbox" @if($element->cloned == true) checked @endif >
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            {{-- <td >
                                                <a id="add_{{ $element->id }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    href="{{ route('seller.elements.edit', ['id' => $element->id, 'lang' => default_language()]) }}"
                                                    title="{{ translate('Add to clone') }}">
                                                    <i class="las la-plus"></i>
                                                </a>

                                                <a hidden id="remove_{{ $element->id }}" class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                                    href="{{ route('seller.elements.edit', ['id' => $element->id, 'lang' => default_language()]) }}"
                                                    title="{{ translate('Remove from clone') }}">
                                                    <i class="las la-check"></i>
                                                </a>
                                            </td> --}}
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
        function clone_selected(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('seller.elements.clone.selected') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Cloning element updated successfully') }}');
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
