<div class="form-group row px-3">
    <img src="{{ uploaded_asset($element->thumbnail_img) ?? static_asset('assets/img/placeholder.jpg') }}"
        height="140" width="140" style="object-fit: cover" style="display:inline-block;">
    <div class="col-md-10">
        <label class="col-from-label font-weight-bold h6">{{ $element->getTranslation('name') }}</label>

        {!! $element->getTranslation('description') !!}
        <input type="text" class="form-control" name="name" placeholder="{{ translate('Product Name') }}" required
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
                        <label for="" class="control-label">{{ translate('Slug') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('SKU') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Price') }}</label>
                        <input type="number" style="width: 100px;" onkeyup="change_input(this.value, 'price_change')"
                            name="price" value="0" min="0" step="0.01" class="form-control">
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
                            onkeyup="change_input(this.value, 'tax_change')" value="0" min="0" step="0.01"
                            class="form-control">
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
                        <label style="display: block;" class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="change_switch(this.checked, 'todays_deal_change')"
                                name="todays_deal" checked>
                            <span></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Published') }}</label>
                        <label style="display: block;" class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="change_switch(this.checked, 'published_change')"
                                name="published" checked>
                            <span></span>
                        </label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('seller_featured') }}</label>
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="change_switch(this.checked, 'seller_featured_change')"
                                name="seller_featured" @if ($element->featured) checked @endif>
                            <span></span>
                        </label>
                    </td>
                    <td>
                        {{ translate('Delete') }}
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($combinations as $index => $combination)
                    <tr class="variant">
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
                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][price]"
                                value="0" min="0" step="0.01" class="form-control price_change" required>
                        </td>
                        <td>
                            <select required class="form-control aiz-selectpicker "
                                name="variation[{{ $index }}][currency]">
                                @foreach ($currencies as $currency)
                                    @if ($currency->code == 'UZB')
                                        <option class="currency_change" value="{{ $currency->id }}" selected>
                                            {{ $currency->code }}</option>
                                    @else
                                        <option class="currency_change" value="{{ $currency->id }}">
                                            {{ $currency->code }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input required type="number" style="width: 100px;"
                                name="variation[{{ $index }}][quantity]" value="0" min="0" step="0.01"
                                class="form-control quantity_change" required>
                        </td>
                        <td>
                            <input required type="number" style="width: 100px;"
                                name="variation[{{ $index }}][discount]" value="0" min="0" step="0.01"
                                class="form-control discount_change" required>
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
                            <input type="number" style="width: 100px;" name="variation[{{ $index }}][tax]"
                                value="0" min="0" step="0.01" class="form-control tax_change" required>
                        </td>
                        <td>
                            <select class="form-control aiz-selectpicker tax_type_change"
                                name="variation[{{ $index }}][tax_type]">
                                <option value="amount">{{ translate('Flat') }}</option>
                                <option value="percent" selected>{{ translate('Percent') }}</option>
                            </select>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="variation[{{ $index }}][todays_deal]"
                                        class="todays_deal_change" checked>
                                    <span></span>
                                </label>
                            </div>

                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <label class="aiz-switch aiz-switch-success mb-0 ">
                                    <input type="checkbox" name="variation[{{ $index }}][published]"
                                        class="published_change" checked>
                                    <span></span>
                                </label>
                            </div>

                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <label class="aiz-switch aiz-switch-success mb-0 ">
                                    <input type="checkbox" name="variation[{{ $index }}][seller_featured]"
                                        class="seller_featured_change" checked>
                                    <span></span>
                                </label>
                            </div>
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
