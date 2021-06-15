@extends('backend.layouts.app')

@section('content')
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <h5 class="mb-0 h6">{{ translate('Add New Product') }}</h5>
    </div>
    <div class="mx-auto col-md-12">
        <form class="form form-horizontal mar-top" action="{{ route('products.store') }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                </div>
                <div class="card-body">
                    {{-- <div class="form-group row"> --}}
                    {{-- <label class="col-md-3 col-from-label">{{translate('Product Name')}} <span --}}
                    {{-- class="text-danger">*</span></label> --}}
                    {{-- <div class="col-md-8"> --}}
                    {{-- <input type="text" class="form-control" name="name" --}}
                    {{-- placeholder="{{ translate('Product Name') }}" required> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{$element->getTranslation('name')}} <span
                                class="text-danger">*</span></label>
                    <div class="col-md-8">

                        <input type="text" class="form-control" name="name"
                                placeholder="{{ translate('Product Name') }}" required
                                value="{{$element->getTranslation('name')}}">
                    </div>
                    </div> --}}
                    <div class="px-3 form-group row">
                        <img src="{{ uploaded_asset($element->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                            height="140" width="140" style="object-fit: cover" style="display:inline-block;">
                        <div class="col-md-10">
                            <label class="col-from-label font-weight-bold h6">{{ $element->getTranslation('name') }}</label>
                            {!! strip_tags($element->getTranslation('description')) !!}
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ translate('Product Name') }}" required
                                value="{{ $element->getTranslation('name') }}" hidden>
                        </div>
                    </div>
                    @if (count($combinations) > 0)
                        <input type="hidden" value="{{ $lang }}" name="lang" class="form-control">
                        <input type="hidden" name="element_id" value="{{ $element->id }}" class="form-control">
                        <div style="overflow-y: scroll; ">
                            <table class="table table-bordered" style="width:1800px">
                                <thead>
                                    <tr>
                                        <td class="text-center">
                                            {{ translate('Image') }}
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Slug') }}</label>
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('SKU') }}</label>
                                        </td>

                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Price') }}</label>
                                            <input type="number" style="width: 100px;"
                                                onkeyup="change_input(this.value, 'price_change')" name="price" value="0"
                                                min="0" step="0.01" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Currency') }}</label>
                                            {{-- <select class="form-control aiz-selectpicker"  name="currency" onchange="change_selection(this.value, 'currency_change')" > --}}
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            {{-- @foreach ($currencies as $currency) --}}
                                            {{-- <option  value="{{$currency->code}}">{{$currency->code}}</option> --}}
                                            {{-- @endforeach --}}
                                            {{-- </select> --}}
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Quantity') }}</label>
                                            <input type="number" style="width: 100px;"
                                                onkeyup="change_input(this.value, 'quantity_change')" name="quantity"
                                                value="0" min="0" step="1" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Discount') }}</label>
                                            <input type="number" style="width: 100px;"
                                                onkeyup="change_input(this.value, 'discount_change')" name="discount"
                                                value="0" min="0" step="0.01" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Discount Type') }}</label>
                                            {{-- <select class="form-control aiz-selectpicker" name="discount_type"> --}}
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            {{-- <option value="amount">{{translate('Flat')}}</option> --}}
                                            {{-- <option value="percent">{{translate('Percent')}}</option> --}}
                                            {{-- </select> --}}
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Delivery Type') }}</label>

                                            {{-- <select class="form-control aiz-selectpicker" name="delivery_type"> --}}
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            {{-- </select> --}}
                                        </td>

                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Tax') }}</label>
                                            <input type="number" style="width: 100px;" name="tax"
                                                onkeyup="change_input(this.value, 'tax_change')" value="0" min="0"
                                                step="0.01" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Tax type') }}</label>
                                            {{-- <select class="form-control aiz-selectpicker" name="tax_type"> --}}
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            {{-- <option value="amount">{{translate('Flat')}}</option> --}}
                                            {{-- <option value="percent">{{translate('Percent')}}</option> --}}
                                            {{-- </select> --}}
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Todays deals') }}</label>
                                            <label class="mb-0 aiz-switch aiz-switch-success">
                                                <input type="checkbox"
                                                    onchange="change_switch(this.checked, 'todays_deal_change')"
                                                    name="todays_deal" @if ($element->todays_deal) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td class="text-center">
                                            <label for="" class="control-label">{{ translate('Published') }}</label>
                                            <label class="mb-0 aiz-switch aiz-switch-success">
                                                <input type="checkbox"
                                                    onchange="change_switch(this.checked, 'published_change')"
                                                    name="published" @if ($element->published) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($combinations as $index => $combination)
                                        <tr class="variant">
                                            <td>
                                                <img src="{{ uploaded_asset($combination->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                                                    height="50" width="50" style="object-fit: cover"
                                                    style="display:inline-block;">
                                            </td>

                                            <td>
                                                <label for="" class="control-label">{{ $combination->name }}</label>
                                                <input type="hidden" name="variation[{{ $index }}][id]"
                                                    value="{{ $combination->id }}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][name]"
                                                    value="{{ $combination->name }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="variation[{{ $index }}][sku]"
                                                    value="{{ $combination->sku }}" class="form-control">
                                            </td>

                                            <td>
                                                <input type="number" style="width: 100px;"
                                                    name="variation[{{ $index }}][price]" value="0" min="0"
                                                    step="0.01" class="form-control price_change" required>
                                            </td>
                                            <td>
                                                <select required class="form-control aiz-selectpicker "
                                                    name="variation[{{ $index }}][currency]">
                                                    @foreach ($currencies as $currency)
                                                        @if ($currency->code == 'UZB')
                                                            <option class="currency_change" value="{{ $currency->id }}"
                                                                selected>{{ $currency->code }}</option>
                                                        @else
                                                            <option class="currency_change" value="{{ $currency->id }}">
                                                                {{ $currency->code }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input required type="number" style="width: 100px;"
                                                    name="variation[{{ $index }}][quantity]" value="0" min="0"
                                                    step="0.01" class="form-control quantity_change" required>
                                            </td>
                                            <td>
                                                <input required type="number" style="width: 100px;"
                                                    name="variation[{{ $index }}][discount]" value="0" min="0"
                                                    step="0.01" class="form-control discount_change" required>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker discount_type_change"
                                                    name="variation[{{ $index }}][discount_type]">
                                                    <option value="amount">{{ translate('Flat') }}</option>
                                                    <option value="percent" selected>{{ translate('Percent') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker delivery_type_change"
                                                    name="variation[{{ $index }}][delivery_type]">
                                                    <option value="free" selected>{{ translate('Free') }}</option>
                                                    <option value="seller">{{ translate('Self') }}</option>
                                                    <option value="tinfis">{{ translate('TINFIS Cargo') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" style="width: 100px;"
                                                    name="variation[{{ $index }}][tax]" value="0" min="0"
                                                    step="0.01" class="form-control tax_change" required>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker tax_type_change"
                                                    name="variation[{{ $index }}][tax_type]">
                                                    <option value="amount">{{ translate('Flat') }}</option>
                                                    <option value="percent" selected>{{ translate('Percent') }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success">
                                                    <input type="checkbox"
                                                        name="variation[{{ $index }}][todays_deal]"
                                                        class="todays_deal_change" @if ($element->todays_deal) checked @endif>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success ">
                                                    <input type="checkbox" name="variation[{{ $index }}][published]"
                                                        class="published_change" @if ($element->published) checked @endif>
                                                    <span></span>
                                                </label>
                                            </td>
                                            {{-- <td>
                                                <button type="button" class="btn btn-icon btn-sm btn-danger"
                                                    onclick="delete_variant(this)"><i class="las la-trash"></i></button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
            <div class="mb-3 text-right">
                <button type="submit" name="button" class="btn btn-primary">{{ translate('Save Product') }}</button>
            </div>
    </div>
    </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function change_input(value, class_name) {
            document.querySelectorAll("." + class_name).forEach(el => {
                el.value = value
            })
        }

        function change_selection(value, class_name) {

            document.querySelectorAll("." + class_name).forEach(el => {
                console.log(el)
                // if(el.value === value){
                //     el.selected = true
                // } else {
                //     el.seleted = false
                // }
            })
        }

        function change_switch(value, class_name) {
            document.querySelectorAll("." + class_name).forEach(el => {
                el.checked = value
            })
        }

        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }

        function update_variation() {
            $('#sku_combination').html(null);
            $.ajax({
                type: "GET",
                url: '{{ route('products.make_combination') }}',
                data: $('#choice_form').serialize(),
                success: function(data) {
                    $('#sku_combination').html(data);
                }
            });
        }
        $('#element_id').on('change', function() {
            update_variation();
        });

        $(document).ready(function() {
            update_variation();
        });

    </script>
@endsection
