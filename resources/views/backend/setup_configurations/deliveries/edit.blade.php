@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Delivery Information') }}</h5>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <form class="p-4"  action="{{ route('deliveries.update', $delivery->id) }}"  method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="distance">{{ translate('To Distance (km)') }}</label>
                        <input type="number" min="0" step="0.01"
                            name="distance" class="form-control" required value="{{ $delivery->distance }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price">{{ translate('Cost per km (sums)') }}</label>
                        <input type="number" min="0" step="0.01"
                            name="price" class="form-control" required value="{{ $delivery->price }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="days">{{ translate('Duration (days)') }}</label>
                        <input type="number" min="0" step="1"
                            name="days" class="form-control" required value="{{ $delivery->days }}">
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
