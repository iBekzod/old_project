@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Add New Product')}}</h5>
    </div>
    <div class="col-md-10 mx-auto">
        <form class="form form-horizontal mar-top" action="{{route('products.store')}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Product Name')}} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name"
                                   placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                        </div>
                    </div>
                    <div class="form-group row" id="element">
                        <label class="col-md-3 col-from-label">{{translate('Element')}} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="element_id" id="element_id"
                                    data-live-search="true" required>
                                @foreach ($elements as $element)
                                     <option value="{{ $element->id }}">{{ $element->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sku_combination" id="sku_combination">

{{--                    @php--}}
{{--                        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();--}}
{{--                    @endphp--}}
{{--                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)--}}
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 col-from-label">{{translate('Refundable')}}</label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <label class="aiz-switch aiz-switch-success mb-0">--}}
{{--                                    <input type="checkbox" name="refundable" checked>--}}
{{--                                    <span></span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
            </div>
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h5 class="mb-0 h6">{{translate('Product Images')}}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Gallery Images')}}--}}
{{--                            <small>{{ translate('(600x600)')}}</small></label>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <div--}}
{{--                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>--}}
{{--                                </div>--}}
{{--                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>--}}
{{--                                <input type="hidden" name="photos" class="selected-files">--}}
{{--                            </div>--}}
{{--                            <div class="file-preview box sm">--}}
{{--                            </div>--}}
{{--                            <small--}}
{{--                                class="text-muted">{{translate('These images are visible in product details page gallery. Use 600x600 sizes images.')}}</small>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}}--}}
{{--                            <small>(300x300)</small></label>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <div class="input-group" data-toggle="aizuploader" data-type="image">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <div--}}
{{--                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>--}}
{{--                                </div>--}}
{{--                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>--}}
{{--                                <input type="hidden" name="thumbnail_img" class="selected-files">--}}
{{--                            </div>--}}
{{--                            <div class="file-preview box sm">--}}
{{--                            </div>--}}
{{--                            <small--}}
{{--                                class="text-muted">{{translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.')}}</small>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h5 class="mb-0 h6">{{translate('Product Variation')}}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="form-group row">--}}
{{--                        <div class="col-md-3">--}}
{{--                            <input type="text" class="form-control" value="{{translate('Colors')}}" disabled>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <select class="form-control aiz-selectpicker" data-live-search="true"--}}
{{--                                    data-selected-text-format="count" name="colors[]" id="colors" multiple disabled>--}}
{{--                                @foreach (\App\Color::orderBy('name', 'asc')->get() as $key => $color)--}}
{{--                                    <option value="{{ $color->code }}"--}}
{{--                                            data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"></option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1">--}}
{{--                            <label class="aiz-switch aiz-switch-success mb-0">--}}
{{--                                <input value="1" type="checkbox" name="colors_active">--}}
{{--                                <span></span>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="form-group row">--}}
{{--                        <div class="col-md-3">--}}
{{--                            <input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-8">--}}
{{--                            <select name="choice_attributes[]" id="choice_attributes"--}}
{{--                                    class="form-control aiz-selectpicker" data-selected-text-format="count"--}}
{{--                                    data-live-search="true" multiple--}}
{{--                                    data-placeholder="{{ translate('Choose Attributes') }}">--}}
{{--                                @foreach (\App\Attribute::all() as $key => $attribute)--}}
{{--                                    <option--}}
{{--                                        value="{{ $attribute->id }}">{{ $attribute->getTranslation('name') }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}</p>--}}
{{--                        <br>--}}
{{--                    </div>--}}

{{--                    <div class="customer_choice_options" id="customer_choice_options">--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h5 class="mb-0 h6">{{translate('Product price + stock')}}</h5>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-from-label">{{translate('Unit price')}} <span--}}
{{--                                class="text-danger">*</span></label>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" lang="en" min="0" value="0" step="0.01"--}}
{{--                                   placeholder="{{ translate('Unit price') }}" name="unit_price" class="form-control"--}}
{{--                                   required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-from-label">{{translate('Purchase price')}} <span--}}
{{--                                class="text-danger">*</span></label>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" lang="en" min="0" value="0" step="0.01"--}}
{{--                                   placeholder="{{ translate('Purchase price') }}" name="purchase_price"--}}
{{--                                   class="form-control" required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-from-label">{{translate('Tax')}} <span--}}
{{--                                class="text-danger">*</span></label>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" lang="en" min="0" value="0" step="0.01"--}}
{{--                                   placeholder="{{ translate('Tax') }}" name="tax" class="form-control" required>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <select class="form-control aiz-selectpicker" name="tax_type">--}}
{{--                                <option value="amount">{{translate('Flat')}}</option>--}}
{{--                                <option value="percent">{{translate('Percent')}}</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group row">--}}
{{--                        <label class="col-md-3 col-from-label">{{translate('Discount')}} <span--}}
{{--                                class="text-danger">*</span></label>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" lang="en" min="0" value="0" step="0.01"--}}
{{--                                   placeholder="{{ translate('Discount') }}" name="discount" class="form-control"--}}
{{--                                   required>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3">--}}
{{--                            <select class="form-control aiz-selectpicker" name="discount_type">--}}
{{--                                <option value="amount">{{translate('Flat')}}</option>--}}
{{--                                <option value="percent">{{translate('Percent')}}</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group row" id="quantity">--}}
{{--                        <label class="col-md-3 col-from-label">{{translate('Quantity')}} <span--}}
{{--                                class="text-danger">*</span></label>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <input type="number" lang="en" min="0" value="0" step="1"--}}
{{--                                   placeholder="{{ translate('Quantity') }}" name="current_stock" class="form-control"--}}
{{--                                   required>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <br>--}}
{{--                    <div class="sku_combination" id="sku_combination">--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'product_wise_shipping')--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <h5 class="mb-0 h6">{{translate('Product Shipping Cost')}}</h5>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <h5 class="mb-0 h6">{{translate('Free Shipping')}}</h5>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 col-from-label">{{translate('Status')}}</label>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <label class="aiz-switch aiz-switch-success mb-0">--}}
{{--                                            <input type="radio" name="shipping_type" value="free" checked>--}}
{{--                                            <span></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-3">--}}
{{--                                <h5 class="mb-0 h6">{{translate('Flat Rate')}}</h5>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-9">--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 col-from-label">{{translate('Status')}}</label>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <label class="aiz-switch aiz-switch-success mb-0">--}}
{{--                                            <input type="radio" name="shipping_type" value="flat_rate" checked>--}}
{{--                                            <span></span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-md-3 col-from-label">{{translate('Shipping cost')}}</label>--}}
{{--                                    <div class="col-md-8">--}}
{{--                                        <input type="number" lang="en" min="0" value="0" step="0.01"--}}
{{--                                               placeholder="{{ translate('Shipping cost') }}" name="flat_shipping_cost"--}}
{{--                                               class="form-control" required>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

            <div class="mb-3 text-right">
                <button type="submit" name="button" class="btn btn-primary">{{ translate('Save Product') }}</button>
            </div>
        </form>
    </div>



@endsection

@section('script')

    <script type="text/javascript">
        {{--function add_more_customer_choice_option(i, name) {--}}
        {{--    $('#customer_choice_options').append('<div class="form-group row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + name + '" placeholder="{{ translate('Choice Title') }}" readonly></div><div class="col-md-8"><input type="text" class="form-control aiz-tag-input" name="choice_options_' + i + '[]" placeholder="{{ translate('Enter choice values') }}" data-on-change="update_sku"></div></div>');--}}

        {{--    AIZ.plugins.tagify();--}}
        {{--}--}}

        // $('input[name="colors_active"]').on('change', function () {
        //     if (!$('input[name="colors_active"]').is(':checked')) {
        //         $('#colors').prop('disabled', true);
        //     } else {
        //         $('#colors').prop('disabled', false);
        //     }
        //     update_sku();
        // });

        // $('#colors').on('change', function () {
        //     update_sku();
        // });
        //
        // $('input[name="unit_price"]').on('keyup', function () {
        //     update_sku();
        // });
        //
        // $('input[name="name"]').on('keyup', function () {
        //     update_sku();
        // });

        // function delete_row(em) {
        //     $(em).closest('.form-group row').remove();
        //     update_sku();
        // }

        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }

        {{--function update_sku() {--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: '{{ route('products.sku_combination') }}',--}}
        {{--        data: $('#choice_form').serialize(),--}}
        {{--        success: function (data) {--}}
        {{--            $('#sku_combination').html(data);--}}
        {{--            if (data.length > 1) {--}}
        {{--                $('#quantity').hide();--}}
        {{--            } else {--}}
        {{--                $('#quantity').show();--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        $('#element_id').on('change', function () {
            $('#customer_choice_options').html(null);
            $.ajax({
                type: "GET",
                url: '{{ route('products.make_combination') }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data);
                    // if (data.length > 1) {
                    //     $('#quantity').hide();
                    // } else {
                    //     $('#quantity').show();
                    // }
                }
            });
        });

        // $('#choice_attributes').on('change', function () {
        //     $('#customer_choice_options').html(null);
        //     $.each($("#choice_attributes option:selected"), function () {
        //         add_more_customer_choice_option($(this).val(), $(this).text());
        //     });
        //     update_sku();
        // });


    </script>

@endsection
