@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h1 class="mb-0 h6">{{ translate('Edit Element') }}</h5>
    </div>
    <div class="col-lg-8 mx-auto">
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
                               href="{{ route('products.admin.edit', ['id'=>$element->id, 'lang'=> $language->code] ) }}">
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
                                   value="{{ $element->getTranslation('name', $lang) }}" required>
                        </div>
                    </div>
                    <div class="form-group row" id="category">
                        <label class="col-lg-3 col-from-label">{{translate('Category')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                    data-selected="{{ $element->category_id }}" data-live-search="true" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
                                    @foreach ($category->children as $childCategory)
                                        @include('categories.child_category', ['child_category' => $childCategory])
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="brand">
                        <label class="col-lg-3 col-from-label">{{translate('Brand')}}</label>
                        <div class="col-lg-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                    data-live-search="true">
                                <option value="">{{ ('Select Brand') }}</option>
                                @foreach (\App\Brand::all() as $brand)
                                    <option value="{{ $brand->id }}"
                                            @if($element->brand_id == $brand->id) selected @endif>{{ $brand->getTranslation('name') }}</option>
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
                                   value="{{$element->getTranslation('unit', $lang)}}" required>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Minimum Qty')}}</label>
                        <div class="col-lg-8">
                            <input type="number" lang="en" class="form-control" name="min_qty"
                                   value="@if($element->min_qty <= 1){{1}}@else{{$element->min_qty}}@endif" min="1"
                                   required>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Tags')}}</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                   value="{{ $element->tags }}" placeholder="{{ translate('Type to add a tag') }}"
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
                                       placeholder="{{ translate('Barcode') }}" value="{{ $element->barcode }}">
                            </div>
                        </div>
                    @endif

                    {{-- @php
                        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                    @endphp
                    @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label">{{translate('Refundable')}}</label>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0" style="margin-top:5px;">
                                    <input type="checkbox" name="refundable"
                                           @if ($element->refundable == 1) checked @endif>
                                    <span class="slider round"></span></label>
                                </label>
                            </div>
                        </div>
                    @endif --}}
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
                    {{-- <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Gallery Images')}}</label>
                        <div class="col-lg-8">
                            <div id="photos">
                                @if(is_array(json_decode($element->photos)))
                                    @foreach (json_decode($element->photos) as $key => $photo)
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="img-upload-preview">
                                                <img loading="lazy"  src="{{ uploaded_asset($photo)??static_asset('assets/img/placeholder.jpg') }}" alt="" class="img-responsive">
                                                <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                                <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{translate('Thumbnail Image')}} <small>(290x300)</small></label>
                        <div class="col-lg-8">
                            <div id="thumbnail_img">
                                @if ($element->thumbnail_img != null)
                                    <div class="col-md-4 col-sm-4 col-xs-6">
                                        <div class="img-upload-preview">
                                            <img loading="lazy"  src="{{ uploaded_asset($element->thumbnail_img)??static_asset('assets/img/placeholder.jpg') }}" alt="" class="img-responsive">
                                            <input type="hidden" name="previous_thumbnail_img" value="{{ $element->thumbnail_img }}">
                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> --}}
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
                                    value="youtube" <?php if ($element->video_provider == 'youtube') echo "selected";?> >{{translate('Youtube')}}</option>
                                <option
                                    value="dailymotion" <?php if ($element->video_provider == 'dailymotion') echo "selected";?> >{{translate('Dailymotion')}}</option>
                                <option
                                    value="vimeo" <?php if ($element->video_provider == 'vimeo') echo "selected";?> >{{translate('Vimeo')}}</option>
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
            {{-- <div class="card">
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
                                    <option
                                        value="{{ $color->code }}"
                                        data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>"
                                     if (in_array($color->code, json_decode($element->colors))) echo 'selected'?>
                                    ></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" type="checkbox"
                                       name="colors_active"  if (count(json_decode($element->colors)) > 0) echo "checked";?> >
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control" value="{{translate('Attributes')}}" disabled>
                        </div>
                        <div class="col-lg-8">
                            <select name="choice_attributes[]" id="choice_attributes" data-selected-text-format="count"
                                    data-live-search="true" class="form-control aiz-selectpicker" multiple
                                    data-placeholder="{{ translate('Choose Attributes') }}">
                                @foreach (\App\Attribute::all() as $key => $attribute)
                                    <option value="{{ $attribute->id }}"
                                            @if($element->attributes != null && in_array($attribute->id, json_decode($element->attributes, true)))
                                            selected @endif>{{ $attribute->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}</p>
                        <br>
                    </div>

                    <div class="customer_choice_options" id="customer_choice_options">
                        @foreach (json_decode($element->choice_options) as $key => $choice_option)
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <input type="hidden" name="choice_no[]" value="{{ $choice_option->attribute_id }}">

                                    @php

                                        $attr = \App\Attribute::find($choice_option->attribute_id);
                                        $name = null;
                                        if ($attr !== null)
                                        $name =    $attr->getTranslation('name');


                                    @endphp

                                    <input type="text" class="form-control" name="choice[]" value="{{ $name  }}"
                                           placeholder="{{ translate('Choice Title') }}" disabled>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control aiz-tag-input"
                                           name="choice_options_{{ $choice_option->attribute_id }}[]"
                                           placeholder="{{ translate('Enter choice values') }}"
                                           value="{{ implode(',', $choice_option->values) }}"
                                           data-on-change="update_sku">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> --}}
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

        $('#colors').on('change', function () {
            update_sku();
        });

        function delete_row(em) {
            $(em).closest('.form-group').remove();
            update_sku();
        }

        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '{{ route('products.sku_combination_edit') }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data);
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        }

        AIZ.plugins.tagify();

        $(document).ready(function () {
            update_sku();

            $('.remove-files').on('click', function () {
                $(this).parents(".col-md-4").remove();
            });
        });

        // $('#choice_attributes').on('change', function () {
        //     $.each($("#choice_attributes option:selected"), function (j, attribute) {
        //         flag = false;
        //         $('input[name="choice_no[]"]').each(function (i, choice_no) {
        //             if ($(attribute).val() == $(choice_no).val()) {
        //                 flag = true;
        //             }
        //         });
        //         if (!flag) {
        //             add_more_customer_choice_option($(attribute).val(), $(attribute).text());
        //         }
        //     });

        //     var str = @php echo $element->attributes @endphp;

        //     $.each(str, function (index, value) {
        //         flag = false;
        //         $.each($("#choice_attributes option:selected"), function (j, attribute) {
        //             if (value == $(attribute).val()) {
        //                 flag = true;
        //             }
        //         });
        //         if (!flag) {
        //             $('input[name="choice_no[]"][value="' + value + '"]').parent().parent().remove();
        //         }
        //     });

        //     update_sku();
        // });

    </script>

@endsection
