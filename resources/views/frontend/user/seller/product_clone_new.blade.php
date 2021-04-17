@extends('frontend.layouts.seller')

@section('css')
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cloneProduct').select2(
                // {
                // ajax: {
                //     url: '/get/all/products',
                //     dataType: 'json',
                //     processResults: function (data) {
                //         console.log(data)
                //         let items = data.products.map((el) => {
                //             return {
                //                 id: el.id,
                //                 text: el.name
                //             }
                //         })

                //         return {
                //             results: items
                //             // pagination: {
                //             //     "more": true
                //             // }
                //         };
                //     }
                // }
                // }
            );
        });
    </script>
@endsection

@section('content')
    NEW
    {{-- <div class="container mt-4">
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
                                <label>{{ translate('Products') }}</label>
                                <select class="form-control selection" name="product_ids[]" multiple="multiple" id="cloneProduct">
                                    @foreach($products as $product)

                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
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
    </div> --}}
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-3">
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                      aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <select name="course" id="course" class="form-control input-lg">
                 <option value="">Select course</option>
                </select>
                <div class="col-md-6 offset-3">
                    <button type="button" class="btn btn-info btn-block">Button</button>
                </div>
            </div>

               <div class="container" id="dropdowns">

               </div>
            </div>
        </div>
    </div>
@endsection
