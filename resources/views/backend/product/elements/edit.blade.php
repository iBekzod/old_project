@extends('backend.layouts.app')
@section('css')
    <style>
        .select2-selection__rendered li{
            background-color: transparent !important;
            border: none;
            border-right: 1px solid #aaa;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            color: gray;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            padding: 0 4px;
            position: absolute;
            left: 0;
            top: 0;
        }
        .select2-selection__rendered li button:hover{
            background: rgba(255, 0, 0, 0.5) !important;
        }
        .select2-selection__rendered li:hover {
            background: rgba(255, 0, 0, 0.3) !important;
        }
    </style>
@endsection



@section('content')
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <h1 class="mb-0 h6">{{ translate('Edit Element') }}</h5>
    </div>
    <div class="mx-auto col-lg-12">
        <form class="form form-horizontal mar-top" action="{{route('elements.update', $element->id)}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            <input name="_method" type="hidden" value="POST">
            <input type="hidden" id="element_id" value="{{ $element->id }}" name="element_id">
            <input type="hidden" name="lang" value="{{ $lang }}">
            <input type="hidden" name="is_new_combination" id="is_new_combination" value="{{ true }}">
            @csrf
            <div class="card">
                <ul class="nav nav-tabs nav-fill border-light">
                    @foreach (\App\Language::all() as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                               href="{{ route('elements.admin.edit', ['id'=>$element->id, 'lang'=> $language->code] ) }}">
                                <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" height="11"
                                     class="mr-1">
                                <span>{{$language->name}}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Element Name')}} <i
                                class="las la-language text-danger"
                                title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="name" id="element_name"
                                   placeholder="{{translate('Element Name')}}"
                                   value="{{ $element->name }}" required onchange="update_sku()">
                        </div>
                    </div>

                    <div class="form-group row" id="brand">
                        <label class="col-lg-3 col-from-label">{{translate('Brand')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                            data-selected="{{ $element->brand_id??null }}"  data-live-search="true">
                                <option value="">{{ ('Select Brand') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->getTranslation('name', $lang) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $units=['kg', 'pcs', 'litre', 'complect']
                    @endphp
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Unit')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="unit" id="unit"
                                    data-live-search="true" required>
                                    <option value="">{{ translate('Select Unit') }}</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit }}" @if($element->unit==$unit) selected @endif>{{ translate($unit) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="weight_id">
                        <label class="col-lg-3 col-from-label">{{translate('Total Weight')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="weight" type="number" min="0" step="0.01"
                                   placeholder="{{ translate('weight (kg)') }}" value="{{$element->weight}}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Tags')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                            value="{{ $element->tags??null }}" placeholder="{{ translate('Type to add a tag') }}"
                                   data-role="tagsinput" required>
                        </div>
                    </div>
                    @php
                        $pos_addon = \App\Addon::where('unique_identifier', 'pos_system')->first();
                    @endphp
                    @if ($pos_addon != null && $pos_addon->activated == 1)
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Barcode')}}</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="barcode"
                                       placeholder="{{ translate('Barcode') }}" value="{{ $element->barcode??null }}">
                            </div>
                        </div>
                    @endif

                    @php
                        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                    @endphp
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Refundable')}}</label>
                            <div class="col-lg-8">
                                <label class="mb-0 aiz-switch aiz-switch-success" style="margin-top:5px;">
                                    <input type="checkbox" name="refundable"
                                           @if ($element->refundable == 1) checked @endif>
                                    <span class="slider round"></span></label>
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Category')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row" id="category">
                        <label class="col-lg-3 col-from-label">{{translate('Category')}}</label>
                        <div class="col-lg-8">
                            <select required class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                    data-selected="{{ $element->category_id??null }}" data-live-search="true" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name', $lang) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $characteristic_attributes=[];
                foreach ($characteristics as $attribute_id=>$value_id){
                    $characteristic_attributes[]=$attribute_id;
                }
            @endphp
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Characteristics')}}</h5>
                </div>
                <div class="card-body">


                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="selected_attribute_ids[]" id="selected_attribute_id" multiple>
                                    @foreach ($element->category->attributes as $attribute)
                                        <option value="{{ $attribute->id }}"
                                            @if(is_array($characteristic_attributes) && in_array($attribute->id, $characteristic_attributes))  selected @endif
                                            >{{ $attribute->getTranslation('name', $lang) }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="attribute_div">
                        @if(isset($characteristics))
                            @foreach ( $characteristics as $attribute_id=>$value_ids)
                                @if($attribute = \App\Attribute::find($attribute_id))
                                <input type="hidden" name="choice_options[{{ $attribute->id }}]" value="{{ $attribute->id }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"  for="signinSrEmail">{{  $attribute->getTranslation('name', $lang) }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control js-example-basic-multiple"  id="choice_option_{{ $attribute->id }}" multiple name="choice_options[{{ $attribute->id }}][]">
                                            @foreach ($attribute->characteristics as $value)
                                                <option
                                                @if(in_array($value->id, $value_ids)) selected @endif
                                                    data-id="{{ $value->id }}"  value = "{{ $value->id }}" > {{ $value->getTranslation('name', $lang) }} </option >
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Variation')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="{{translate('Colors')}}" disabled>
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="colors[]" id="colors" multiple>
                                @foreach ($colors as $key => $color)
                                    <option data-id="{{$color->id}}" @if(is_array($variation_colors) && in_array($color->id, $variation_colors)) selected @endif value="{{$color->id}}"  data-content="<span><span class='mr-2 border rounded size-15px d-inline-block' style='background:{{ $color->code }}'></span><span>{{ $color->getTranslation('name', $lang) }}</span></span>"></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="selected_variations[]" id="selected_variations" multiple>
                                @foreach (\App\Attribute::where('combination', true)->whereIn('id', $characteristic_attributes)->get() as $attribute)
                                    <option value="{{ $attribute->id }}" data-id="{{ $attribute->id }}"
                                        @if(is_array($variation_attributes) && in_array($attribute->id, $variation_attributes))  selected @endif
                                        >{{ $attribute->getTranslation('name', $lang) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-block">
                        <button type="button" class="mb-3 btn btn-info" onclick="update_attribute_combination()">{{ translate('Generate variations') }}</button>
                    </div>
                    <div id="variation_div">
                        @include('backend.product.elements.variation_combination', ['combinations'=>$element->combinations])
                        {{-- <div style="overflow-y: scroll; ">
                            <table class="table table-bordered" >
                                <thead>
                                <tr>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('#') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label class="col-form-label" for="signinSrEmails">{{ translate('Variation Image') }}
                                                <small>{{ translate('(290x300)') }}</small></label>
                                    </td>
                                    <td class="text-center">
                                        <label class="col-form-label" for="signinSrEmails">{{ translate('Gallery Images') }}
                                                <small>{{ translate('(600x600)') }}</small></label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Name') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Artikul') }}</label>
                                    </td>
                                    <td class="text-center">
                                        <label for="" class="control-label">{{ translate('Delete') }}</label>
                                    </td>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($element->combinations as $index=>$combination)
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
                                            <label for="" class="control-label">{{ $combination->name??null }}</label>
                                            <input type="hidden" name="combination[{{ $index }}][name]" value="{{ $combination->name??null }}" class="form-control">
                                            <input type="text" hidden name="combination[{{ $index }}][id]" value="{{ $combination->id??null }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="combination[{{ $index }}][artikul]" value="{{ $combination->partnum??null }}" class="form-control">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variantion(this, '{{ $combination->id }}')"><i class="las la-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div> --}}

                    </div>
                    <input type="hidden" name="collected_variations[]" id="collected_variations" >
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Images')}}</h5>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                               for="signinSrEmail">{{translate('Gallery Images')}}<small>{{ translate('(600x600)')}}</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div
                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photos" value="{{ $element->photos }}"
                                       class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                            <small
                                class="text-muted">{{translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.')}}</small>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Thumbnail Image')}}
                            <small>(290x300)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div
                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="thumbnail_img" value="{{ $element->thumbnail_img }}"
                                       class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Videos')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Video Provider')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="video_provider" id="video_provider">
                                <option
                                    value="youtube" @if($element->video_provider == 'youtube') selected @endif >{{translate('Youtube')}}</option>
                                <option
                                    value="dailymotion" @if($element->video_provider == 'dailymotion') selected @endif  >{{translate('Dailymotion')}}</option>
                                <option
                                    value="vimeo" @if($element->video_provider == 'vimeo') selected @endif  >{{translate('Vimeo')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Video Link')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="video_link" value="{{ $element->video_link }}"
                                   placeholder="{{ translate('Video Link') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Description')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}} <i
                                class="las la-language text-danger"
                                title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-9">
                            <textarea class="aiz-text-editor"
                                      name="description">{{ $element->getTranslation('description', $lang) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('PDF Specification')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                               for="signinSrEmail">{{translate('PDF Specification')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader">
                                <div class="input-group-prepend">
                                    <div
                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="pdf" value="{{ $element->pdf }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('SEO Meta Tags')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Meta Title')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="meta_title" value="{{ $element->meta_title }}"
                                   placeholder="{{translate('Meta Title')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-lg-8">
                            <textarea name="meta_description" rows="8"
                                      class="form-control">{{ $element->meta_description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{translate('Meta Images')}}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                <div class="input-group-prepend">
                                    <div
                                        class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="meta_img" value="{{ $element->meta_img }}"
                                       class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" >
                        <label class="col-md-3 col-form-label">{{translate('Slug')}}</label>
                        <div class="col-md-8">
                            <input type="text" placeholder="{{translate('Slug')}}" id="slug" name="slug"
                                   value="{{ $element->slug }}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 text-right">
                <button type="submit" name="button" class="btn btn-info">{{ translate('Update Element') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // $('#choice_form').submit(function (event) {
        //     event.preventDefault();
        // });
        function add_more_customer_choice_option(i, name) {
            $('#customer_choice_options').append('<div class="form-group row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + name + '" placeholder="{{ translate('Choice Title') }}" readonly></div><div class="col-md-8"><input type="text" class="form-control aiz-tag-input" name="choice_options_' + i + '[]" placeholder="{{ translate('Enter choice values') }}" data-on-change="update_sku"></div></div>');

            AIZ.plugins.tagify();
        }
        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors').prop('disabled', true);
            } else {
                $('#colors').prop('disabled', false);
            }
            update_sku();
        });
        $('#category_id').on('change', function () {
            update_attribute();
        });
        $('#selected_attribute_id').on('change', function () {
            update_category_attribute();
        });
        function update_attribute(){
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_attribute_options') }}',
                data:{
                    category_id: $('#category_id option:selected').val()
                },
                success:function(data){
                    // alert("Selected attribute id: "+data.message);
                    $('#selected_attribute_id').html(" ")
                    if(data.success){
                        $('#selected_attribute_id').html(data.data)
                        $('#selected_attribute_id').change()
                    }
                    // update_category_attribute();
                }
            });
        }

        function delete_variantion(em, variation_id){
            $('#variant_'+variation_id).remove()
            $.ajax({
                type:'GET',
                url:'{{ route("elements.variation.remove") }}',
                data:{
                    id: variation_id
                },
                success:function(data){
                    if(data.success){
                        delete_variant(em);
                    }
                }
            });
        }
        function update_category_attribute(){
            attribute_ids = $('#selected_attribute_id').val()
            // $('#selected_attribute_id option:selected').each(function (index, val){
            //     attribute_ids.push(val.getAttribute('data-id'))
            // })
            // choice_groups = [];
            // alert(attribute_ids);
            choice_options = [];
            $.each(attribute_ids, function( index, value ) {
                $('#choice_option_'+value+' option:selected').each(function (index, val){
                    choice_options.push(val.getAttribute('data-id'))
                    // console.log(val.getAttribute('data-id'));
                })
                // if(choice_options.length > 0){
                    // choice_groups[value]=choice_options
                // }
            });
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_selected_attribute_options') }}',
                data:{
                    selected_attribute_ids: $('#selected_attribute_id').val(),
                    choice_groups:choice_options,
                },
                success:function(data){
                    $('#attribute_div').html(" ")
                    if(data.success){
                        $('#attribute_div').html(data.data)
                        $('.js-example-basic-multiple').select2();
                    }
                    update_attribute_variation();
                }
            });
        }
        function update_attribute_variation(){
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_attribute_variations') }}',
                data:{
                    selected_attribute_ids: $('#selected_attribute_id').val()
                },
                success:function(data){
                    $('#selected_variations').html(" ")
                    if(data.success){
                        $('#selected_variations').html(data.data)
                        $('.js-example-basic-multiple').select2();
                    }
                }
            });
        }
        function update_attribute_combination(){
            var $element_name = $('#element_name').val();
            if($element_name.length<3){
                console.log("Element name is not full:"+$('#element_name').val())
                return;
            }
            // $('.variant').remove();
            // alert("Combination changed")
            attribute_ids = []
            $('#selected_variations option:selected').each(function (index, val){
                attribute_ids.push(val.getAttribute('data-id'))
            })
            choice_groups = [];
            $.each(attribute_ids, function( index, value ) {
                choice_options = [];
                $('#choice_option_'+attribute_ids[index]+' option:selected').each(function (index, val){
                    choice_options.push(val.getAttribute('data-id'))
                    console.log(val.getAttribute('data-id'));
                })
                // if(choice_options.length > 0){
                    choice_groups[index]=choice_options
                // }
            });


            color_ids = []
            $('#colors option:selected').each(function (index, val){
                color_ids.push(val.getAttribute('data-id'))
            })
            // alert("Element id: "+$('#element_id').val())
            element_id=$('#element_id').val();
            $('#collected_variations').val(choice_groups);
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_all_combination') }}',
                data:{
                    element_id:element_id,
                    selected_attribute_ids: attribute_ids,
                    choice_groups: choice_groups,
                    color_ids: color_ids,
                    element_name: $element_name
                },
                success:function(data){
                    $('#variation_div').html(" ")
                    // alert("Combinations: "+data.message)
                    // console.log(data.message);
                    if(data.success){

                        $('#variation_div').html(data.data)
                        AIZ.uploader.initForInput();
                        AIZ.uploader.removeAttachment();
                        AIZ.uploader.previewGenerate();
                    }
                }
            });
        }
        // selected_variations
        function update_sku() {
        }
        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }
        AIZ.plugins.tagify();
        $(document).ready(function () {
            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();
            });
        });
    </script>
@endsection
