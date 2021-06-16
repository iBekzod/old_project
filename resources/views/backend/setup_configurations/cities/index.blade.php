@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="h3">{{ translate('All cities') }}</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New region') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="country">{{ translate('Country') }}</label>
                                    <select class="select2 form-control aiz-selectpicker" name="country_id"
                                        data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->getTranslation('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="country">{{ translate('Parent Region') }}</label>
                                    <select class="select2 form-control aiz-selectpicker" name="region_id"
                                        data-toggle="select2" data-placeholder="Choose ..." data-live-search="true">
                                        <option selected value="0">{{ translate('Country') }}</option>
                                        @foreach ($all_cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->getTranslation('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="country">{{ translate('Type') }}</label>
                                    <select class="select2 form-control aiz-selectpicker" name="type" data-toggle="select2"
                                        data-placeholder="Choose ..." data-live-search="true">
                                        <option value="region">{{ translate('region') }}</option>
                                        <option value="city">{{ translate('city') }}</option>
                                        <option value="district">{{ translate('district') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name">{{ translate('Name') }}</label>
                                    <input type="text" placeholder="{{ translate('Name') }}" name="name"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name">{{ translate('Distance (km)') }}</label>
                                    <input type="number" min="0" step="0.01" placeholder="{{ translate('Distance (km)') }}"
                                        name="distance" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mt-4 text-right">
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
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Cities') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_cities" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                                    value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type name & Enter') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Country') }}</th>
                                <th>{{ translate('Distance (km)') }}</th>
                                <th>{{ translate('Type') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $key => $city)
                                <tr>
                                    <td>{{ $key + 1 + ($cities->currentPage() - 1) * $cities->perPage() }}</td>
                                    <td>{{ $city->getTranslation('name') }}</td>
                                    <td>
                                        @if ($city->parent)
                                            {{ $city->parent->getTranslation('name') }}@else
                                            {{ $city->country->getTranslation('name') }} @endif
                                    </td>
                                    <td>{{ $city->distance }}</td>
                                    <td>{{ translate($city->type) }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('cities.edit', ['id' => $city->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('cities.destroy', $city->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $cities->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
        }

    </script>
@endsection
