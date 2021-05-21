@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Edit Product')}}</h5>
    </div>
    <div class="col-md-12 mx-auto">
        <form class="form form-horizontal mar-top" action="{{route('products.update', $variation->id)}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{$variation->getTranslation('name')}} <span
                                class="text-danger">*</span></label>
{{--                        <div class="col-md-8">--}}
{{--                            <input type="text" class="form-control" name="name"--}}
{{--                                   placeholder="{{ translate('Product Name') }}" required--}}
{{--                                   value="{{$variation->getTranslation('name')}}">--}}
{{--                        </div>--}}
                    </div>
                    @if(count($products) > 0)
                        <input type="hidden" value="{{$lang}}" name="lang" class="form-control">

                        <div style="overflow-y: scroll; ">
                            <table class="table table-bordered" style="width:1800px">
                                <thead>
                                <tr>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Slug') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Price') }}</label>
                                        <input type="number" onkeyup="change_input(this.value, 'price_change')"
                                               name="price" value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Currency') }}</label>
                                        {{--                <select class="form-control aiz-selectpicker"  name="currency" onchange="change_selection(this.value, 'currency_change')" >--}}
                                        {{--                    <option value="no">{{translate('Selected value')}}</option>--}}
                                        {{--                    @foreach($currencies as $currency)--}}
                                        {{--                        <option  value="{{$currency->code}}">{{$currency->code}}</option>--}}
                                        {{--                    @endforeach--}}
                                        {{--                </select>--}}
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Quantity') }}</label>
                                        <input type="number" onkeyup="change_input(this.value, 'quantity_change')"
                                               name="quantity" value="0" min="0" step="1" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount') }}</label>
                                        <input type="number" onkeyup="change_input(this.value, 'discount_change')"
                                               name="discount" value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount Type') }}</label>
                                        {{--                <select class="form-control aiz-selectpicker" name="discount_type">--}}
                                        {{--                    <option value="no">{{translate('Selected value')}}</option>--}}
                                        {{--                    <option value="amount">{{translate('Flat')}}</option>--}}
                                        {{--                    <option value="percent">{{translate('Percent')}}</option>--}}
                                        {{--                </select>--}}
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Delivery Type') }}</label>
                                        {{--                <select class="form-control aiz-selectpicker" name="delivery_type">--}}
                                        {{--                    <option value="no">{{translate('Selected value')}}</option>--}}
                                        {{--                </select>--}}
                                    </td>

                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax') }}</label>
                                        <input type="number" name="tax" onkeyup="change_input(this.value, 'tax_change')"
                                               value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax type') }}</label>
                                        {{--                <select class="form-control aiz-selectpicker" name="tax_type">--}}
                                        {{--                    <option value="no">{{translate('Selected value')}}</option>--}}
                                        {{--                    <option value="amount">{{translate('Flat')}}</option>--}}
                                        {{--                    <option value="percent">{{translate('Percent')}}</option>--}}
                                        {{--                </select>--}}
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Todays deals') }}</label>
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox"
                                                   onchange="change_switch(this.checked, 'todays_deal_change')"
                                                   name="todays_deal" checked>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Published') }}</label>
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox"
                                                   onchange="change_switch(this.checked, 'published_change')"
                                                   name="published" checked>
                                            <span></span>
                                        </label>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)
                                    <tr class="variant">
                                        <td>
                                            <label for="" class="control-label">{{$product->getTranslation('name')}}</label>
                                            <input type="hidden" name="variation[{{ $product->id }}][slug]"
                                                   value="{{$product->slug??null}}" class="form-control">
                                            <input type="hidden" name="variation[{{ $product->id }}][name]"
                                                   value="{{$product->name??null}}"
                                                   class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="variation[{{ $product->id }}][price]"
                                                   value="{{$product->price??0}}" min="0" step="0.01"
                                                   class="form-control price_change" required>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker "
                                                    name="variation[{{ $product->id }}][currency]">
                                                @foreach($currencies as $currency)
                                                    @if($currency->id==$product->currency_id)
                                                        <option class="currency_change" value="{{$currency->id}}"
                                                                selected>{{$currency->code}}</option>
                                                    @else
                                                        <option class="currency_change"
                                                                value="{{$currency->id}}">{{$currency->code}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="variation[{{ $product->id }}][quantity]"
                                                   value="{{$product->qty??0}}" min="0" step="0.01"
                                                   class="form-control quantity_change" required>
                                        </td>
                                        <td>
                                            <input type="number" name="variation[{{ $product->id }}][discount]" min="0"
                                                   step="0.01" class="form-control discount_change" required
                                                   value="{{$product->discount??0}}">
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker discount_type_change"
                                                    name="variation[{{ $product->id }}][discount_type]">
                                                <option value="amount">{{translate('Flat')}}</option>
                                                <option value="percent" selected>{{translate('Percent')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker delivery_type_change"
                                                    name="variation[{{ $product->id }}][delivery_type]">
                                                <option value="amount">{{translate('Tinfis')}}</option>
                                                <option value="percent" selected>{{translate('Free')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="variation[{{ $product->id }}][tax]"
                                                   value="{{$product->tax??0}}" min="0" step="0.01"
                                                   class="form-control tax_change" required>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker tax_type_change"
                                                    name="variation[{{ $product->id }}][tax_type]">
                                                <option value="amount">{{translate('Flat')}}</option>
                                                <option value="percent" selected>{{translate('Percent')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox" name="variation[{{ $product->id }}][todays_deal]"
                                                       class="todays_deal_change" @if($product->todays_deal) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="aiz-switch aiz-switch-success mb-0 ">
                                                <input type="checkbox" name="variation[{{ $product->id }}][published]"
                                                       class="published_change" @if($product->published) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-sm btn-danger"
                                                    onclick="delete_variant(this)"><i class="las la-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="mb-3 text-right">
                    <button type="submit" name="button" class="btn btn-primary">{{ translate('Update Product') }}</button>
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
                success: function (data) {
                    $('#sku_combination').html(data);
                }
            });
        }

        $('#element_id').on('change', function () {
            update_variation();
        });
        $( document ).ready(function () {
            update_variation();
        });
    </script>
@endsection
