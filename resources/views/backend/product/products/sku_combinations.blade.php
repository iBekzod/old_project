@if(count($combinations[0]) > 0)
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="text-center">
					<label for="" class="control-label">{{translate('Slug')}}</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label">{{translate('Price')}}</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label">{{translate('Quantity')}}</label>
				</td>
                <td class="text-center">
                    <label for="" class="control-label">{{translate('Discount')}}</label>
                </td>
				<td></td>
			</tr>
		</thead>
		<tbody>


@foreach ($combinations as $combination)
			<tr class="variant">
				<td>
					<label for="" class="control-label">{{ $combination->slug }}</label>
				</td>
				<td>
					<input type="number" lang="en" name="price_{{ $combination->id }}" value="{{ $combination->price }}" min="0" step="0.01" class="form-control" required>
				</td>
				<td>
					<input type="text" name="sku_{{ $combination->id }}" value="" class="form-control">
				</td>
				<td>
					<input type="number" lang="en" name="qty_{{ $combination->id }}" value="10" min="0" step="1" class="form-control" required>
				</td>
				<td>
					<button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(this)"><i class="las la-trash"></i></button>
				</td>
			</tr>
@endforeach
	</tbody>
</table>
@endif
