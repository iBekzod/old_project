@extends('backend.layouts.app')

@section('content')
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <div class="align-items-center d-flex justify-content-between">
            <h1 class="h3">{{ translate('Delivery tarifs') }}</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                    {{ translate('Add New Delivery Tarif') }}
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
                                <th>{{ translate('From') }}</th>
                                <th>{{ translate('To') }}</th>
                                <th>{{ translate('Distance (km)') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivery_tarifs as $key => $delivery)
                                <tr>
                                    <td>{{ $key + 1 + ($delivery_tarifs->currentPage() - 1) * $delivery_tarifs->perPage() }}</td>
                                    <td>{{ $delivery->from_region->getTranslation('name') }}</td>
                                    <td>{{ $delivery->to_region->getTranslation('name') }}</td>
                                    <td>{{ $delivery->distance }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                        title="{{ translate('Edit') }}" data-toggle="modal"
                                        data-target="#EditModal_{{ $delivery->id }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('delivery_tarifs.destroy', $delivery->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    <form class="p-4" action="{{ route('delivery_tarifs.update', $delivery->id) }}"
                                        method="POST">
                                        <div class="overflow-hidden modal fade" id="EditModal_{{ $delivery->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            {{ translate('Edit Delivery tarif') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('From') }}</label>
                                                            <select class="form-control aiz-selectpicker" name="seller_region_id" id="seller_region_id" data-live-search="true" required>
                                                                @foreach ($regions as $region)
                                                                    <option @if($region->id==$delivery->seller_region_id) selected @endif value="{{ $region->id }}">{{ $region->getTranslation('name') }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('To') }}</label>
                                                            <select class="form-control aiz-selectpicker" name="client_region_id" id="client_region_id"
                                                                    data-live-search="true" required>
                                                                @foreach ($regions as $region)
                                                                    <option @if($region->id==$delivery->client_region_id) selected @endif value="{{ $region->id }}" >{{ $region->getTranslation('name') }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3 form-group row">
                                                            <label for="name">{{ translate('Distance') }}</label>
                                                            <input type="number" min="0" step="1" placeholder="{{ translate('in km') }}"
                                                                name="days" class="form-control" required
                                                                value="{{ $delivery->distance }}">
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
                        {{ $delivery_tarifs->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Modal -->
    <form action="{{ route('delivery_tarifs.store') }}" class="overflow-hidden " method="POST">
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('Add New Delivery Tarif') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('From') }}</label>
                            <select class="form-control aiz-selectpicker" name="seller_region_id" id="seller_region_id"
                                    data-live-search="true" required>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}" >{{ $region->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('To') }}</label>
                            <select class="form-control aiz-selectpicker" name="client_region_id" id="client_region_id"
                                    data-live-search="true" required>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 form-group row">
                            <label for="name">{{ translate('Distance') }}</label>
                            <input type="number" min="0" step="1" placeholder="{{ translate('in km') }}"
                                name="days" class="form-control" required
                                value="">
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
