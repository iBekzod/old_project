@extends('frontend.layouts.seller')

@section('content')

    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h1 class="h3">{{ translate('My Flash Deals') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{translate('Flash Deal Information')}}</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('seller.marketing.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label" for="name">{{translate('Title')}}</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{translate('Title')}}" id="name" name="title" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label" for="background_color">{{translate('Background Color')}} <small>(Hexa-code)</small></label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{translate('#FFFFFF')}}" id="background_color" name="background_color" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 control-label" for="name">{{translate('Text Color')}}</label>
                                            <div class="col-lg-9">
                                                <select name="text_color" id="text_color" class="form-control aiz-selectpicker" required>
                                                    <option value="">{{translate('Select One')}}</option>
                                                    <option value="white">{{translate('White')}}</option>
                                                    <option value="dark">{{translate('Dark')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Banner')}} <small>(150x150)</small></label>
                                            <div class="col-md-9">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                    <input type="hidden" name="banner" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                                <span class="small text-muted">{{ translate('This image is shown as cover banner in flash deal details page.') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label" for="start_date">{{translate('Date')}}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to " autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label class="col-sm-3 control-label" for="products">{{translate('Products')}}</label>
                                            <div class="col-sm-9">
                                                <select name="products[]" id="products" class="form-control aiz-selectpicker" multiple required data-placeholder="{{ translate('Choose Products') }}" data-live-search="true" data-selected-text-format="count">
                                                    @foreach(\App\Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get() as $product)
                                                        <option value="{{$product->id}}">{{ $product->getTranslation('name') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group row" id="discount_table">

                                        </div>
                                        <div class="form-group mb-0 text-right">
                                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#products').on('change', function(){
                var product_ids = $('#products').val();
                if(product_ids.length > 0){
                    $.post('{{ route('seller.flash_deals.product_discount') }}', {_token:'{{ csrf_token() }}', product_ids:product_ids}, function(data){
                        $('#discount_table').html(data);
                        $(".aiz-selectpicker").selectpicker();
                    });
                }
                else{
                    $('#discount_table').html(null);
                }
            });
        });
    </script>
@endsection


