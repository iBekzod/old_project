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
@php
    if(!isset($lang)){
        $lang=default_language();
    }
@endphp
    <div class="mt-2 mb-3 text-left aiz-titlebar">
        <h1 class="mb-0 h6">{{ translate('Create Element') }}</h5>
    </div>
    <div class="mx-auto col-lg-12">
        <form class="form form-horizontal mar-top" action="{{route('elements.store')}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="lang" value="{{ $lang??default_language() }}">
            <input type="hidden" name="added_by" value="admin">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Element Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Element Name')}} <i
                                class="las la-language text-danger"
                                title="{{translate('Translatable')}}"></i></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="name" id="element_name"
                                   placeholder="{{translate('Element Name')}}"
                                   value="" required>
                        </div>
                    </div>

                    <div class="form-group row" id="brand">
                        <label class="col-lg-3 col-from-label">{{translate('Brand')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                    data-live-search="true" required>
                                <option value="">{{ ('Select Brand') }}</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
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
                                    <option value="{{ $unit }}">{{ translate($unit) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="weight_id">
                        <label class="col-lg-3 col-from-label">{{translate('Total Weight')}}</label>
                        <div class="col-lg-8">
                            <input class="form-control" name="weight" type="number" min="0" step="0.01"  type="number" min="0" step="0.01"
                                   placeholder="{{ translate('weight (kg)') }}" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Tags')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                   value="" placeholder="{{ translate('Type to add a tag') }}"
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
                                       placeholder="{{ translate('Barcode') }}" value="">
                            </div>
                        </div>
                    @endif
                    @php
				        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                    @endphp
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{translate('Refundable')}}</label>
                            <div class="col-md-8">
                            <label class="mb-0 aiz-switch aiz-switch-success">
                                <input type="checkbox" name="refundable" checked>
                                <span></span>
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
                            <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                    data-selected="" data-live-search="true" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
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
                                    {{-- <option value="" disabled>{{translate('Select Attribute')}}</option> --}}
                            </select>
                        </div>
                    </div>
                    <div id="attribute_div">
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
                                @foreach (\App\Color::orderBy('name', 'asc')->get() as $key => $color)
                                    <option data-id="{{$color->id}}" value="{{$color->id}}"  data-content="<span><span class='mr-2 border rounded size-15px d-inline-block' style='background:{{ $color->code }}'></span><span>{{ $color->getTranslation('name', $lang) }}</span></span>"></option>
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
                                    {{-- <option value="" disabled>{{translate('Select Attribute')}}</option> --}}
                                {{-- @foreach (\App\Color::orderBy('name', 'asc')->get() as $key => $color)
                                    <option value="" data-content="<span><span class='mr-2 border rounded size-15px d-inline-block' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"></option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                    <div class="d-block">
                        <button type="button" class="mb-3 btn btn-info" onclick="update_attribute_combination()">{{ translate('Generate variations') }}</button>
                    </div>
                    <div id="variation_div"></div>
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
                                <input type="hidden" name="photos" value=""
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
                                <input type="hidden" name="thumbnail_img" value=""
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
                                    value="youtube"  >{{translate('Youtube')}}</option>
                                <option
                                    value="dailymotion"  >{{translate('Dailymotion')}}</option>
                                <option
                                    value="vimeo"  >{{translate('Vimeo')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Video Link')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" name="video_link" value=""
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
                                      name="description"></textarea>
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
                                <input type="hidden" name="pdf" value="" class="selected-files">
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
                            <input type="text" class="form-control" name="meta_title" value=""
                                   placeholder="{{translate('Meta Title')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Description')}}</label>
                        <div class="col-lg-8">
                            <textarea name="meta_description" rows="8"
                                      class="form-control"></textarea>
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
                                <input type="hidden" name="meta_img" value=""
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
                                   value="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 text-right">
                <button type="submit" name="button" class="btn btn-info">{{ translate('Save Element') }}</button>
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
                    }
                    update_category_attribute();
                }
            });
        }
        function update_category_attribute(){
            attribute_ids = $('#selected_attribute_id').val()
            choice_options = [];
            $.each(attribute_ids, function( index, value ) {
                $('#choice_option_'+value+' option:selected').each(function (index, val){
                    choice_options.push(val.getAttribute('data-id'))
                })
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
        // function update_category_attribute(){
        //     $.ajax({
        //         type:'GET',
        //         url:'{{ route('elements.make_selected_attribute_options') }}',
        //         data:{
        //             selected_attribute_ids: $('#selected_attribute_id').val()
        //         },
        //         success:function(data){
        //             $('#attribute_div').html(" ")
        //             if(data.success){
        //                 $('#attribute_div').html(data.data)
        //                 $('.js-example-basic-multiple').select2();
        //             }
        //             update_attribute_variation();
        //         }
        //     });
        // }
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
                    // update_attribute_combination();
                }
            });
        }
        function update_attribute_combination(){
            var $element_name = $('#element_name').val();
            if($element_name.length<3){
                console.log("Element name is not full:"+$('#element_name').val())
                return;
            }
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
            // update_sku();

            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();
            });
        });

        // $('#unit').on('change', function () {
        //     alert($('#unit').val());
        //     if($('#unit').val()=='kg' || $('#unit').val()=='pcs'){
        //         $('#weight_id').show();
        //     }else{
        //         $('#weight_id').hide();
        //     }
        // });
    </script>
@endsection
