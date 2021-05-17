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
            <input type="hidden" name="id" value="{{ $element->id }}">
            <input type="hidden" name="lang" value="{{ $lang }}">
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
                            <input type="text" class="form-control" name="name"
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
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Unit')}} <i
                                class="las la-language text-danger" title="{{translate('Translatable')}}"></i>
                        </label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="unit"
                                   placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}"
                                   value="{{ $element->unit??null }}" required>
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
                            <select required class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="selected_attribute_ids[]" id="selected_attribute_id" multiple>
                                    @foreach ($element->category->attributes as $attribute)
                                        <option value="{{ $attribute->id }}"
                                            @if(in_array($attribute->id, $characteristic_attributes))  selected @endif
                                            >{{ $attribute->getTranslation('name', $lang) }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="attribute_div">
                        @if(is_array($characteristics))
                            @foreach ( $characteristics as $attribute_id=>$value_ids)
                                @php
                                    $attribute = \App\Attribute::findOrFail($attribute_id);
                                @endphp
                                <input type="hidden" name="choice_options[{{ $attribute->id }}]" value="{{ $attribute->id }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label"  for="signinSrEmail">{{  $attribute->getTranslation('name', $lang) }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control js-example-basic-multiple" onchange="update_attribute_combination()" id="choice_option_{{ $attribute->id }}" multiple name="choice_options[{{ $attribute->id }}][]">
                                            @foreach ($attribute->characteristics as $value)
                                                <option
                                                @if(in_array($value->id, $value_ids)) selected @endif
                                                    data-id="{{ $value->id }}"  value = "{{ $value->id }}" > {{ $value->getTranslation('name', $lang) }} </option >
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @php
                            // $content = null;
                            // foreach($selected_attributes as $attribute){
                            //     $content = $content . '<input type="hidden" name="choice_options[' . $attribute->id . ']" value="' . $attribute->id . '">
                            //         <div class="form-group row">
                            //             <label class="col-md-3 col-form-label"  for="signinSrEmail">' . $attribute->getTranslation('name') . '</label>
                            //             <div class="col-md-8">
                            //                 <select class="form-control js-example-basic-multiple" onchange="update_attribute_combination()" id="choice_option_' . $attribute->id . '" multiple name="choice_options[' . $attribute->id . '][]">';

                            //     $options = null;
                            //     foreach ($attribute->characteristics as $value) {
                            //         $options = $options . '<option selected  data-id="'.$value->id.'" ';
                            //         // if ($request->has('id') && $element->characteristics != null && in_array($value->id, json_decode($element->characteristics, true))) {
                            //         //     $options = $options . 'selected';
                            //         // }
                            //         $options = $options . ' value = "' . $value->id . '" > ' . $value->getTranslation('name') . ' </option >';
                            //     }

                            //     $content = $content . $options . '</select>
                            //             </div>
                            //         </div>';
                            // }
                        @endphp
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
                            <select required class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="colors[]" id="colors" multiple>
                                @foreach ($colors as $key => $color)
                                    <option data-id="{{$color->id}}" @if(in_array($color->id, $variation_colors)) selected @endif value="{{$color->id}}"  data-content="<span><span class='mr-2 border rounded size-15px d-inline-block' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>
                        </div>
                        <div class="col-lg-8">
                            <select required class="form-control aiz-selectpicker" data-live-search="true"
                                    data-selected-text-format="count" name="selected_variations[]" id="selected_variations" multiple>
                                    @foreach (\App\Attribute::whereIn('id', $characteristic_attributes)->get() as $attribute)
                                        <option value="{{ $attribute->id }}"
                                            @if(in_array($attribute->id, $variation_attributes))  selected @endif
                                            >{{ $attribute->getTranslation('name', $lang) }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="variation_div">
                        <div style="overflow-y: scroll; ">
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
                                <tr class="variant">
                                    <td>
                                        <label for="" class="control-label">{{ ($index+1) }}</label>
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
                                        <label for="" class="control-label">{{ $combination->name??null }}</label>
                                        <input type="hidden" name="combination[{{ $index }}][name]" value="{{ $combination->name??null }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="combination[{{ $index }}][artikul]" value="{{ $combination->artikul??null }}" class="form-control">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-sm btn-danger" onclick="delete_variant(this)"><i class="las la-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>

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
        $('#colors').on('change', function () {
            update_attribute_combination()
        });
        // $('#selected_colors').on('change', function () {
        //     update_attribute_combination()
        // });
        $('#selected_variations').on('change', function () {
            update_attribute_combination()
        });
        {{--function update_color(){--}}
        {{--    color_ids = []--}}
        {{--    $('#colors option:selected').each(function (index, val){--}}
        {{--        color_ids.push(val.getAttribute('data-id'))--}}
        {{--    })--}}
        {{--    // alert(color_ids);--}}
        {{--    $.ajax({--}}
        {{--        type:'GET',--}}
        {{--        url:'{{ route('elements.make_color_options') }}',--}}
        {{--        data:{--}}
        {{--            colors: color_ids--}}
        {{--        },--}}
        {{--        success:function(data){--}}
        {{--            // alert("Selected attribute id: "+data.message);--}}
        {{--            $('#selected_colors').html(" ")--}}
        {{--            if(data.success){--}}
        {{--                $('#selected_colors').append(data.data)--}}
        {{--            }--}}
        {{--            update_attribute_combination();--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
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
                    }
                    update_category_attribute();
                }
            });
        }
        function update_category_attribute(){
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_selected_attribute_options') }}',
                data:{
                    selected_attribute_ids: $('#selected_attribute_id').val()
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
                    update_attribute_combination();
                }
            });
        }
        function update_attribute_combination(){
            attribute_ids = []
            $('#selected_variations option:selected').each(function (index, val){
                attribute_ids.push(val.getAttribute('data-id'))
            })
            choice_groups = [];
            $.each(attribute_ids, function( index, value ) {
                choice_options = [];
                $('#choice_option_'+attribute_ids[index]+' option:selected').each(function (index, val){
                    choice_options.push(val.getAttribute('data-id'))
                })
                // if(choice_options.length > 0){
                    choice_groups[index]=choice_options
                // }
            });
            // console.log(choice_groups);

            color_ids = []
            $('#colors option:selected').each(function (index, val){
                color_ids.push(val.getAttribute('data-id'))
            })
            // alert("Colors: "+color_ids)

            $('#collected_variations').val(choice_groups);
            $.ajax({
                type:'GET',
                url:'{{ route('elements.make_all_combination') }}',
                data:{
                    selected_attribute_ids: attribute_ids,
                    choice_groups: choice_groups,
                    color_ids: color_ids
                },
                success:function(data){
                    $('#variation_div').html(" ")
                    // alert("Combinations: "+data.message)
                    // console.log(data.message);
                    if(data.success){
                        $('#variation_div').html(data.data)
                        $('.js-example-basic-multiple').select2();
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
            // update_attribute_combination();

            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();
            });
        });
    </script>
@endsection
