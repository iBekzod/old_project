@if(count($combinations[0]) > 0)
<input type="hidden" lang="{{$lang}}" name="lang" class="form-control">
<div style="overflow-y: scroll; ">
    <table class="table table-bordered" style="width:1800px">
        <thead>
        <tr>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Slug') }}</label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Price') }}</label>
                <input type="number" name="price" value="0" min="0" step="0.01" class="form-control" >
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Currency') }}</label>
                <select class="form-control aiz-selectpicker" name="currency">
                    <option value="no">{{translate('Selected value')}}</option>
                    <option value="amount">{{translate('Som')}}</option>
                    <option value="percent">{{translate('USD')}}</option>
                </select>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Quantity') }}</label>
                <input type="number" name="quantity" value="0" min="0" step="1" class="form-control" >
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Discount') }}</label>
                <input type="number" name="price" value="0" min="0" step="0.01" class="form-control" >
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Discount Type') }}</label>
                <select class="form-control aiz-selectpicker" name="discount_type">
                    <option value="no">{{translate('Selected value')}}</option>
                    <option value="amount">{{translate('Flat')}}</option>
                    <option value="percent">{{translate('Percent')}}</option>
                </select>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Delivery Type') }}</label>
                <select class="form-control aiz-selectpicker" name="delivery_type">
                    <option value="no">{{translate('Selected value')}}</option>
                </select>
            </td>

            <td class="text-center">
                <label for="" class="control-label">{{ translate('Tax') }}</label>
                <input type="number" name="tax" value="0" min="0" step="0.01" class="form-control" >
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Tax type') }}</label>
                <select class="form-control aiz-selectpicker" name="tax_type">
                    <option value="no">{{translate('Selected value')}}</option>
                    <option value="amount">{{translate('Flat')}}</option>
                    <option value="percent">{{translate('Percent')}}</option>
                </select>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Todays deals') }}</label>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" name="todays_deal" checked>
                    <span></span>
                </label>
            </td>
            <td class="text-center">
                <label for="" class="control-label">{{ translate('Published') }}</label>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" name="published" checked>
                    <span></span>
                </label>
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach ($combinations as $index=>$combination)
        <tr class="variant">
            <td>
                <label for="" class="control-label">{{implode (",", $combination)}}</label>
                <input type="hidden" name="variation[{{ $index }}][slug]" value="{{implode("-", $combination)}}" class="form-control">
            </td>
            <td>
                <input type="number" name="variation[{{ $index }}][price]" value="0" min="0" step="0.01" class="form-control" required>
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="variation[{{ $index }}][currency]">
                    <option value="amount">{{translate('Som')}}</option>
                    <option value="percent">{{translate('USD')}}</option>
                </select>
            </td>
            <td>
                <input type="number" name="variation[{{ $index }}][quantity]" value="0" min="0" step="0.01" class="form-control" required>
            </td>
            <td>
                <input type="number" name="variation[{{ $index }}][discount]" value="0" min="0" step="0.01" class="form-control" required>
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="variation[{{ $index }}][discount_type]">
                    <option value="amount">{{translate('Flat')}}</option>
                    <option value="percent" selected>{{translate('Percent')}}</option>
                </select>
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="variation[{{ $index }}][delivery_type]">
                    <option value="amount">{{translate('Tinfis')}}</option>
                    <option value="percent" selected>{{translate('Free')}}</option>
                </select>
            </td>
            <td>
                <input type="number" name="variation[{{ $index }}][tax]" value="0" min="0" step="0.01" class="form-control" required>
            </td>
            <td>
                <select class="form-control aiz-selectpicker" name="variation[{{ $index }}][tax_type]">
                    <option value="amount">{{translate('Flat')}}</option>
                    <option value="percent" selected>{{translate('Percent')}}</option>
                </select>
            </td>
            <td>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" name="variation[{{ $index }}][todays_deal]" checked>
                    <span></span>
                </label>
            </td>
            <td>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" name="variation[{{ $index }}][published]" checked>
                    <span></span>
                </label>
            </td>
            <td>
                <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(this)"><i class="las la-trash"></i></button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endif
