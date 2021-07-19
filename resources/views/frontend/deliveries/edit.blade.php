@extends('frontend.layouts.app')

@section('content')
<section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('Delivery Information') }}</h1>
                            </div>
                        </div>
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
                </div>
            </div>
        </div>
    </section>
@endsection
