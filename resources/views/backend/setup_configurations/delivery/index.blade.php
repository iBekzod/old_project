@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="h3">{{ translate('Delivery metrics') }}</h1>
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
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name">{{ translate('To Distance (km)') }}</label>
                                    <input type="number" min="0" step="0.01" placeholder="{{ translate('Distance (km)') }}"
                                        name="distance" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label for="name">{{ translate('Cost per km (sums)') }}</label>
                                    <input type="number" min="0" step="0.01" placeholder="{{ translate('Distance (km)') }}"
                                        name="price" class="form-control" required>
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
                        <h5 class="mb-md-0 h6">{{ translate('Deliveries') }}</h5>
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
                                <th>{{ translate('To Distance (km)') }}</th>
                                <th>{{ translate('Cost per km (sums)') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $key => $delivery)
                                <tr>
                                    <td>{{ $key + 1 + ($deliveries->currentPage() - 1) * $deliveries->perPage() }}</td>
                                    <td>{{ $delivery->distance }}</td>
                                    <td>{{ $delivery->price }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('deliveries.edit', ['id' => $city->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('deliveries.destroy', $city->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
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
