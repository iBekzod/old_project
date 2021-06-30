@extends('backend.layouts.app')

@section('content')
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <h5 class="mb-0 h6">{{translate('Edit Product')}}</h5>
    </div>
    <div class="mx-auto col-md-12">
        <form class="form form-horizontal mar-top" action="{{route('products.update', $element->id)}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
            <input type="hidden" value="{{$lang}}" name="lang" class="form-control">
            <input type="hidden"  name="element_id" value="{{$element->id}}" class="form-control">

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="px-3 form-group row">
                        <img src="{{ uploaded_asset($element->thumbnail_img)??static_asset('assets/img/placeholder.jpg') }}" height="140" width="140" style="object-fit: cover" style="display:inline-block;">
                      <div class="col-md-10">
                        <label class="col-from-label font-weight-bold h6">{{$element->getTranslation('name')}}</label>

                            {!! strip_tags($element->getTranslation('description')) !!}
                          <input type="text" class="form-control" name="name"
                                 placeholder="{{ translate('Product Name') }}" required
                                 value="{{$element->getTranslation('name')}}" hidden>
                      </div>
                    </div>
                    {{-- @if(count($combinations)>0) --}}
                        <div style="overflow-y: scroll; ">
                            <table class="table table-bordered" style="width:1800px">
                                <thead>
                                <tr>
                                    <td class="text-center">
                                        {{ translate('Image') }}
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Name') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('SKU') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Price') }}</label>
                                        <input style="width: 100px;" type="number" onkeyup="change_input(this.value, 'price_change')"
                                               name="price" value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Currency') }}</label>
                                        <select class="form-control aiz-selectpicker"  name="currency" onchange="change_selection(this.value, 'currency_change')" >
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            @foreach($currencies as $currency)
                                                <option  value="{{$currency->code}}" @if($currency->code=='USD') selected @endif>{{$currency->code}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Quantity') }}</label>
                                        <input type="number" style="width: 100px;" onkeyup="change_input(this.value, 'quantity_change')"
                                               name="quantity" value="0" min="0" step="1" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount') }}</label>
                                        <input type="number" style="width: 100px;" onkeyup="change_input(this.value, 'discount_change')"
                                               name="discount" value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount Type') }}</label>
                                        <select class="form-control aiz-selectpicker" name="discount_type">
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            <option value="amount">{{translate('Flat')}}</option>
                                            <option value="percent" selected>{{translate('Percent')}}</option>
                                        </select>
                                    </td>
                                    <td class="text-center">

                                        <label for="" class="control-label">{{ translate('Delivery Type') }}</label>
                                        <select class="form-control aiz-selectpicker" name="delivery_type">
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            <option value="free" >{{ translate('Free') }}</option>
                                            <option value="seller">{{ translate('Self') }}</option>
                                            <option value="tinfis" selected>{{ translate('TINFIS Cargo') }}</option>
                                        </select>
                                    </td>

                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax') }}</label>
                                        <input type="number" style="width: 100px;" name="tax" onkeyup="change_input(this.value, 'tax_change')"
                                               value="0" min="0" step="0.01" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax type') }}</label>
                                        <select class="form-control aiz-selectpicker" name="tax_type">
                                            {{-- <option value="no">{{translate('Selected value')}}</option> --}}
                                            <option value="amount">{{translate('Flat')}}</option>
                                            <option value="percent" selected>{{translate('Percent')}}</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Todays deals') }}</label>
                                        <label class="mb-0 aiz-switch aiz-switch-success">
                                            <input type="checkbox"
                                                   onchange="change_switch(this.checked, 'todays_deal_change')"
                                                   name="todays_deal"  @if($element->todays_deal) checked @endif>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Featured') }}</label>
                                        <label class="mb-0 aiz-switch aiz-switch-success">
                                            <input type="checkbox"
                                                   onchange="change_switch(this.checked, 'featured_change')"
                                                   name="featured" @if($element->featured) checked @endif>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Published') }}</label>
                                        <label class="mb-0 aiz-switch aiz-switch-success">
                                            <input type="checkbox"
                                                   onchange="change_switch(this.checked, 'published_change')"
                                                   name="published"  @if($element->published) checked @endif>
                                            <span></span>
                                        </label>
                                    </td>
                                    {{-- <td>
                                        {{translate('Delete')}}
                                    </td> --}}

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($combinations as $combination)
                                    @php
                                        $index=$combination->id;
                                    @endphp
                                    @if($combination->is_new)
                                        <tr class="variant">
                                            <td>
                                                <img src="{{ uploaded_asset($combination->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
                                                    height="50" width="50" style="object-fit: cover"
                                                    style="display:inline-block;">
                                            </td>

                                            <td>
                                                <label for="" class="control-label">{{ $combination->name }}</label>
                                                <input type="hidden" name="variation[{{ $index }}][id]"
                                                    value="{{ null }}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][name]"
                                                    value="{{ $combination->name }}" class="form-control">

                                                <input type="hidden" name="variation[{{ $index }}][variation_id]"
                                                    value="{{$index??null}}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][slug]"
                                                    value="{{$combination->slug??null}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="variation[{{ $index }}][sku]"
                                                    value="" class="form-control">
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
                                                        <option class="currency_change" value="{{ $currency->id }}"
                                                            @if($currency->code=='USD') selected @endif> {{ $currency->code }}</option>
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
                                                    <option value="free" >{{ translate('Free') }}</option>
                                                    <option value="seller">{{ translate('Self') }}</option>
                                                    <option value="tinfis" selected>{{ translate('TINFIS Cargo') }}</option>
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
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox"
                                                    name="variation[{{ $index }}][featured]"
                                                    class="featured_change" @if($element->featured) checked @endif>
                                                    <span class="slider round"></span>
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

                                                {{translate('Is new!')}}
                                            </td> --}}
                                        </tr>
                                    @else
                                        <tr class="variant">
                                            <td>
                                                <img src="{{ uploaded_asset($combination->thumbnail_img)??static_asset('assets/img/placeholder.jpg') }}" height="50" width="50" style="object-fit: cover" style="display:inline-block;">
                                            </td>
                                            <td>
                                                <label for="" class="control-label">{{$combination->getTranslation('name')}}</label>
                                                <input type="hidden" name="variation[{{ $index }}][id]"
                                                    value="{{$combination->variant->id??null}}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][variation_id]"
                                                    value="{{$index??null}}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][slug]"
                                                    value="{{$combination->slug??null}}" class="form-control">
                                                <input type="hidden" name="variation[{{ $index }}][name]"
                                                    value="{{$combination->name??null}}"
                                                    class="form-control">

                                            </td>
                                            <td>
                                            <input type="text" name="variation[{{ $index }}][sku]" value="{{$combination->variant->sku}}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" style="width: 100px;" name="variation[{{ $index }}][price]"
                                                    value="{{$combination->variant->price??0}}" min="0" step="0.01"
                                                    class="form-control price_change" required>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker "
                                                        name="variation[{{ $index }}][currency]">
                                                    @foreach($currencies as $currency)
                                                        <option class="currency_change" value="{{$currency->id}}"
                                                            @if($currency->code==$combination->variant->currency->code) selected @endif>{{$currency->code}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" style="width: 100px;" name="variation[{{ $index }}][quantity]"
                                                    value="{{$combination->variant->qty??0}}" min="0" step="0.01"
                                                    class="form-control quantity_change" required>
                                            </td>
                                            <td>
                                                <input type="number" style="width: 100px;" name="variation[{{ $index }}][discount]" min="0"
                                                    step="0.01" class="form-control discount_change" required
                                                    value="{{$combination->variant->discount??0}}">
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker discount_type_change"
                                                        name="variation[{{ $index }}][discount_type]">
                                                    <option value="amount">{{translate('Flat')}}</option>
                                                    <option value="percent" selected>{{translate('Percent')}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker delivery_type_change"
                                                        name="variation[{{ $index }}][delivery_type]">
                                                        <option value="free" >{{translate('Free')}}</option>
                                                        <option value="seller">{{translate('Self')}}</option>
                                                        <option value="tinfis" selected>{{translate('TINFIS Cargo')}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" style="width: 100px;" name="variation[{{ $index }}][tax]"
                                                    value="{{$combination->variant->tax??0}}" min="0" step="0.01"
                                                    class="form-control tax_change" required>
                                            </td>
                                            <td>
                                                <select class="form-control aiz-selectpicker tax_type_change"
                                                        name="variation[{{ $index }}][tax_type]">
                                                    <option value="amount">{{translate('Flat')}}</option>
                                                    <option value="percent" selected>{{translate('Percent')}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success">
                                                    <input type="checkbox" name="variation[{{ $index }}][todays_deal]"
                                                        class="todays_deal_change" @if($combination->variant->todays_deal) checked @endif>
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox"
                                                    name="variation[{{ $index }}][featured]"
                                                    class="featured_change" @if($combination->variant->seller_featured) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="mb-0 aiz-switch aiz-switch-success ">
                                                    <input type="checkbox" name="variation[{{ $index }}][published]"
                                                        class="published_change" @if($combination->variant->published) checked @endif>
                                                    <span></span>
                                                </label>
                                            </td>
                                            {{-- <td>
                                                <a href="{{ route('products.destroy', $combination->variant->id) }}"
                                                    class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                    title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            <td> --}}
                                        </tr>
                                    @endif
                                @endforeach


                                </tbody>
                            </table>
                        </div>


                    {{-- @endif --}}
                </div>
                <div class="mb-3 text-right">
                    <button type="submit" name="button" class="btn btn-primary">{{ translate('Update Products') }}</button>
                </div>
            </div>
        </form>

        @foreach ($seller_products as $seller_id=>$seller_products)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{\App\User::find($seller_id)->name}}</h5>
                </div>
                <div class="card-body">
                    <div style="overflow-y: scroll; ">
                        <table class="table table-bordered" style="width:1800px">
                            <thead>
                                <tr>
                                    <td class="text-center">
                                        {{ translate('Image') }}
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Name') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('SKU') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Price') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Currency') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Quantity') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Discount Type') }}</label>

                                    </td>
                                    <td class="text-center">

                                        <label for="" class="control-label">{{ translate('Delivery Type') }}</label>

                                    </td>

                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Tax type') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Todays deals') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Featured') }}</label>

                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Published') }}</label>

                                    </td>
                                    {{-- <td>
                                        {{translate('Delete')}}
                                    </td> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($seller_products as $seller_product)
                                    @php
                                        $index=$seller_product->id;
                                    @endphp
                                    <tr class="variant">
                                        <td>
                                            <img src="{{ uploaded_asset($seller_product->variation->thumbnail_img)??static_asset('assets/img/placeholder.jpg') }}" height="50" width="50" style="object-fit: cover" style="display:inline-block;">
                                        </td>
                                        <td>
                                            <label for="" class="control-label">{{$seller_product->variation->getTranslation('name')}}</label>
                                            <input type="hidden" name="variation[{{ $index }}][id]"
                                                value="{{$seller_product->id??null}}" class="form-control">
                                            <input type="hidden" name="variation[{{ $index }}][variation_id]"
                                                value="{{$index??null}}" class="form-control">
                                            <input type="hidden" name="variation[{{ $index }}][slug]"
                                                value="{{$seller_product->slug??null}}" class="form-control">
                                            <input type="hidden" name="variation[{{ $index }}][name]"
                                                value="{{$seller_product->name??null}}"
                                                class="form-control">

                                        </td>
                                        <td>
                                        <input type="text" name="variation[{{ $index }}][sku]" value="{{$seller_product->sku}}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][price]"
                                                value="{{$seller_product->price??0}}" min="0" step="0.01"
                                                class="form-control price_change" required>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker "
                                                    name="variation[{{ $index }}][currency]">
                                                @foreach($currencies as $currency)
                                                    <option class="currency_change" value="{{$currency->id}}"
                                                        @if($currency->code==$seller_product->currency->code) selected @endif>{{$currency->code}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][quantity]"
                                                value="{{$seller_product->qty??0}}" min="0" step="0.01"
                                                class="form-control quantity_change" required>
                                        </td>
                                        <td>
                                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][discount]" min="0"
                                                step="0.01" class="form-control discount_change" required
                                                value="{{$seller_product->discount??0}}">
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker discount_type_change"
                                                    name="variation[{{ $index }}][discount_type]">
                                                <option value="amount">{{translate('Flat')}}</option>
                                                <option value="percent" selected>{{translate('Percent')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker delivery_type_change"
                                                    name="variation[{{ $index }}][delivery_type]">
                                                    <option value="free" >{{translate('Free')}}</option>
                                                    <option value="seller">{{translate('Self')}}</option>
                                                    <option value="tinfis" selected>{{translate('TINFIS Cargo')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][tax]"
                                                value="{{$seller_product->tax??0}}" min="0" step="0.01"
                                                class="form-control tax_change" required>
                                        </td>
                                        <td>
                                            <select class="form-control aiz-selectpicker tax_type_change"
                                                    name="variation[{{ $index }}][tax_type]">
                                                <option value="amount">{{translate('Flat')}}</option>
                                                <option value="percent" selected>{{translate('Percent')}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label class="mb-0 aiz-switch aiz-switch-success">
                                                <input type="checkbox" name="variation[{{ $index }}][todays_deal]"
                                                    class="todays_deal_change" @if($seller_product->todays_deal) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox"
                                                name="variation[{{ $index }}][featured]"
                                                class="featured_change" @if($seller_product->seller_featured) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="mb-0 aiz-switch aiz-switch-success ">
                                                <input type="checkbox" name="variation[{{ $index }}][published]"
                                                    class="published_change" @if($seller_product->published) checked @endif>
                                                <span></span>
                                            </label>
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('products.destroy', $seller_product->id) }}"
                                                class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        <td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
@endsection
@section('modal')
    @include('modals.delete_modal')
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
    </script>
@endsection
