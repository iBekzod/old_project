@extends('frontend.layouts.app')

@section('css_pre')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('#cloneProduct').select2({
                ajax: {
                    url: '/api/v1/get/all/products',
                    dataType: 'json',
                    processResults: function (data) {
                        console.log(data)
                        let items = data.products.map((el) => {
                            return {
                                id: el.id,
                                text: el.name
                            }
                        })

                        return {
                            results: items
                            // pagination: {
                            //     "more": true
                            // }
                        };
                    }
                }
            })
        })
    </script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ translate('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ translate('Product Clone') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('seller.products.clone') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Products</label>
                                <select class="form-control" name="product_id" id="cloneProduct"></select>
                                @error('product_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-danger">
                                    {{ translate('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection