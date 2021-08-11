@extends('backend.layouts.app')

@section('content')
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <div class="align-items-center d-flex justify-content-between">
            <h1 class="h3">{{ translate('Delivery Prices') }}</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                    {{ translate('Add New Delivery Price') }}
                </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table mb-0 aiz-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Distance') }}</th>
                                <th>{{ translate('Cost per km (sums)') }}</th>
                                <th>{{ translate('Duration (days)') }}</th>
                                <th>{{ translate('Delivery Cost per kg')}}</th>
                                <th>{{ translate('Express percent') }}</th>
                                <th>{{ translate('Express Duration (hours)') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $key => $delivery)
                                <tr>
                                    <td>{{ $key + 1 + ($deliveries->currentPage() - 1) * $deliveries->perPage() }}</td>
                                    <td>{{ $delivery->distance }}</td>
                                    <td>{{ $delivery->distance_price }}</td>
                                    <td>{{ $delivery->days }}</td>
                                    <td>{{ $delivery->weight_price }}</td>
                                    <td>{{ $delivery->express_percent }}</td>
                                    <td>{{ $delivery->express_hours }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                        title="{{ translate('Edit') }}" data-toggle="modal"
                                        data-target="#EditModal_{{ $delivery->id }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('delivery_prices.destroy', $delivery->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    <form class="p-4" action="{{ route('delivery_prices.update', $delivery->id) }}"
                                        method="POST">
                                        <div class="overflow-hidden modal fade" id="EditModal_{{ $delivery->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{ translate('Edit Delivery Price') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('Distance (km)') }}</label>
                                                            <input type="number" min="0" step="0.001"  placeholder="{{ translate('in km') }}"
                                                                name="distance" class="form-control" required
                                                                value="{{ $delivery->distance }}">
                                                        </div>
                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('Cost per km (sums)') }}</label>
                                                            <input type="number" min="0" step="0.01" placeholder="{{ translate('in sums') }}"
                                                                name="distance_price" class="form-control" required
                                                                value="{{ $delivery->distance_price }}">
                                                        </div>

                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('Duration (days)') }}</label>
                                                            <input type="number" min="0" step="1" placeholder="{{ translate('in days') }}"
                                                                name="days" class="form-control" required
                                                                value="{{ $delivery->days }}">
                                                        </div>

                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{translate('Delivery Cost per kg')}}</label>
                                                            <input type="number" min="0" step="0.01" placeholder="{{translate('in sums')}}"
                                                                name="weight_price" class="form-control" required
                                                                value="{{ $delivery->weight_price }}">
                                                        </div>

                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{translate('Express percent')}}</label>
                                                            <input type="number" min="0" step="1" max="100" placeholder="{{translate('in percent from 1 to 100')}}"
                                                                name="express_percent" class="form-control" required
                                                                value="{{ $delivery->express_percent }}">
                                                        </div>

                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('Express Duration (hours)') }}</label>
                                                            <input type="number" min="0" step="1" placeholder="{{ translate('in hours') }}"
                                                                name="express_hours" class="form-control" required
                                                                value="{{ $delivery->express_hours }}">
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

    <!-- Modal -->
    <form action="{{ route('delivery_prices.store') }}" class="overflow-hidden " method="POST">
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('Add New Delivery Price') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('Distance (km)') }}</label>
                            <input type="number" min="0" step="0.001"   placeholder="{{ translate('in km') }}"
                                name="distance" class="form-control" required>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('Cost per km (sums)') }}</label>
                            <input type="number" min="0" step="0.01" placeholder="{{ translate('in sums') }}"
                                name="distance_price" class="form-control" required>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('Duration (days)') }}</label>
                            <input type="number" min="0" step="1" placeholder="{{ translate('in days') }}"
                                name="days" class="form-control" required>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="name">{{translate('Delivery Cost per kg')}}</label>
                            <input type="number" min="0" step="0.01" placeholder="{{translate('in sums')}}"
                                name="weight_price" class="form-control" required>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="name">{{translate('Express percent')}}</label>
                            <input type="number" min="0" step="1" max="100" placeholder="{{translate('in percent from 1 to 100')}}"
                                name="express_percent" class="form-control" required>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('Express Duration (hours)') }}</label>
                            <input type="number" min="0" step="1" placeholder="{{ translate('in hours') }}"
                                name="express_hours" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ translate('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
