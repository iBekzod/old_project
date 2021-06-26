@if($combination->edit??true)
    <tr id="variant_{{ $combination->id }}" >
        <td>
            <input type="hidden" name="combination[{{ $index }}][variation_id]" value="{{ $combination->id }}">
            <label for="" class="control-label">{{ ($index+1) }}</label>
            <input type="hidden" name="combination[{{ $index }}][color_id]" value="{{ $combination->color_id??null }}">
            <input type="hidden" name="combination[{{ $index }}][attribute_id]" value="{{ $combination->characteristics??null }}">
        </td>
        <td>
            <div class="form-group">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div
                                class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                        </div>
                        <div class="form-control file-amount"></div>
                        <input type="hidden" name="combination[{{ $index }}][thumbnail_img]" value="{{ $combination->thumbnail_img??null }}"
                            class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
            </div>
        </td>
        <td>
            <div class="form-group">
                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{  translate('Browse')}}</div>
                    </div>
                    <input type="hidden" name="combination[{{ $index }}][photos]" value="{{ $combination->photos }}" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </td>
        <td>
            <label for="" class="control-label">{{ $combination->name }}</label>
            <input type="hidden" name="combination[{{ $index }}][name]" value="{{ $combination->name??null }}" class="form-control">
            <input type="text" hidden name="combination[{{ $index }}][id]" value="{{ $combination->id??null }}" class="form-control">
        </td>
        <td>
            <input type="text" name="combination[{{ $index }}][artikul]" value="{{ $combination->partnum??null }}" class="form-control">
        </td>
        {{-- <td>
            <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variantion(this, '{{ $combination->id }}')"><i class="las la-trash"></i></button>
        </td> --}}
    </tr>
@else
    <tr class="variant">
        <td>
            <label for="" class="control-label">{{ ($index + 1) }}</label>
            <input type="hidden" name="combination[{{ $index }}][color_id]" value="{{ $combination->color_id }}">
            <input type="hidden" name="combination[{{ $index }}][attribute_id]" value="{{ $combination->attribute_id }}">
        </td>
        <td>
            <div class="form-group">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div
                                class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount"></div>
                        <input type="hidden" name="combination[{{ $index }}][thumbnail_img]" value=""
                            class="selected-files">
                    </div>
                    <div class="file-preview box sm">
                    </div>
            </div>
        </td>
        <td>
            <div class="form-group">
                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                    </div>
                    <div class="form-control file-amount"></div>
                    <input type="hidden" name="combination[{{ $index }}][photos]" value="" class="selected-files">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </td>
        <td>
            <label for="" class="control-label">{{ $combination->full_name }}</label>
            <input type="hidden" name="combination[{{ $index }}][name]" value="{{ $combination->name }}" class="form-control">
        </td>
        <td>
            <input type="text" name="combination[{{ $index }}][artikul]" value="" class="form-control">
        </td>
        {{-- <td>
            <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(this)"><i class="las la-trash"></i></button>
        </td> --}}
    </tr>
@endif

