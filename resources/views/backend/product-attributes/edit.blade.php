@extends('backend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Attribute Information') }}</h5>
    </div>

    <div class="row">
        <div class="col-md-12 offset-9 mr-4 pb-2">
            <button type="button" class="btn btn-primary" id="attr" data-toggle="modal" data-target="#exampleModalCenter">
                Add Attribute
            </button>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mb-0 h6" id="exampleModalLongTitle">{{ translate('Add Attribute') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('product-attributes.add_attr') }}" method="POST">
                            <input type="hidden" name="attribute_id" value="{{ $attr->id }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">{{ translate('Name') }}</label>
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                    class="form-control" required>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                data-dismiss="modal">{{ translate('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Attributes') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Name') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $key => $attribute)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $attribute->getTranslation('name') }}
                                        <a href="#" type="button" data-toggle="modal" data-target="#ModalOne">
                                            <i class="las la-language text-danger" title="Translatable"></i>
                                        </a>
                                        <div class="modal fade" id="ModalOne" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="p-4"
                                                            action="{{ route('product-attributes.update', $attr->id) }}"
                                                            method="POST">
                                                            <input name="_method" type="hidden" value="PATCH">
                                                            <input type="hidden" name="lang" value="{{ $lang }}">
                                                            @csrf
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-from-label"
                                                                    for="name">{{ translate('Name') }} </label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        placeholder="{{ translate('Name') }}"
                                                                        class="form-control" id="getName">
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                        </button>
                                                        <div class="form-group text-right">
                                                            <button type="submit" class="btn btn-primary"
                                                                data-dismiss="modal"
                                                                id="getBtn">{{ translate('Save') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('product-attributes.edit_attr', [$attribute->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                            data-toggle="modal" data-target="#exampleModalTwo">
                                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalTwo" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ translate('Change categories') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('product-attributes.change_categories', $attr->id) }}"
                                                            method="POST">
                                                            <input type="hidden" name="attribute_id"
                                                                value="{{ $attr->id }}">
                                                            @csrf
                                                            <div class="form-group" id="category">
                                                                <label>{{ translate('Category') }}</label>
                                                                <select multiple="multiple"
                                                                    class="form-control js-example-basic-multiple"
                                                                    name="category_id[]" id="category_id"
                                                                    data-live-search="true" required>
                                                                    {{-- <select multiple class="form-control aiz-selectpicker" name="category_id[]"
                                                                    id="category_id"
                                                                    data-live-search="true" required> --}}
                                                                    @foreach ($categories as $category)
                                                                        @foreach ($category->children as $childCategory)
                                                                            @include('backend.product-attributes.components.child_category',
                                                                            ['child_category'
                                                                            => $childCategory,'selected_categories' =>
                                                                            $selected_categories])
                                                                        @endforeach
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                        </button>
                                                        <div class="form-group text-right">
                                                            <button type="submit" class="btn btn-primary"
                                                                data-dismiss="modal">{{ translate('Save') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('product-attributes.destroy_attr', $attribute->id) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                                onclick="return confirm('{{ translate('Are you sure?') }}')"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    {{-- new --}}
    <div style="overflow-y: scroll; ">
        <table class="table table-bordered" style="width:1800px">
            <thead>
                <tr>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Slug') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Price') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('crwd') }}</label>
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
                        <label for="" class="control-label">{{ translate('Delivery') }}</label>
                    </td>

                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Tax') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Tax type') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Todays deels') }}</label>
                    </td>
                    <td class="text-center">
                        <label for="" class="control-label">{{ translate('Published') }}</label>
                    </td>
                </tr>
                <th>Hello World!</th>
                <th>
                    <input type="text" class="form-control" id="exampleInputEmail1">
                </th>
                <th>
                    <select class="form-control aiz-selectpicker" name="select1" id="select1">
                        <option value="1">Erkaklar Kiyimi</option>
                        <option value="2">Ayolar Kiyimi</option>
                        <option value="2">Bollalar Kiyimi</option>
                    </select>
                </th>
                <th>
                    <input type="text" class="form-control" id="exampleInputEmail1">
                </th>
                <th>
                    <input type="text" class="form-control" id="exampleInputEmail1">
                </th>
                <th>
                    <select class="form-control aiz-selectpicker" name="select1" id="select1">
                        <option value="1">Erkaklar Kiyimi</option>
                        <option value="2">Ayolar Kiyimi</option>
                        <option value="2">Bollalar Kiyimi</option>
                    </select>
                </th>
                <th>
                    <select class="form-control aiz-selectpicker" name="select1" id="select1">
                        <option value="1">Erkaklar Kiyimi</option>
                        <option value="2">Ayolar Kiyimi</option>
                        <option value="2">Bollalar Kiyimi</option>
                    </select>
                </th>
                <th>
                    <input type="text" class="form-control" id="exampleInputEmail1">
                </th>
                <th>
                    <select class="form-control aiz-selectpicker" name="select1" id="select1">
                        <option value="1">Erkaklar Kiyimi</option>
                        <option value="2">Ayolar Kiyimi</option>
                        <option value="2">Bollalar Kiyimi</option>
                    </select>
                </th>
                <th>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </th>
                <th>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </th>
            </thead>
        </table>
    </div>
    <style>
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $("#getBtn").click(function(event) {
        //         var Data = {
        //                name : $("#getName").val(),
        //         };

        //         $.ajax({
        //             type: "POST",
        //             url: "\test",
        //             data: Data,
        //             dataType: "json",
        //             encode: true,
        //         }).done(function(data) {
        //             alert(data);
        //         });
        //         event.preventDefault();
        //     });
        // });
        $(document).ready(function() {
            $("form").on("submit", function(event) {
                event.preventDefault();

                var formValues = $(this).serialize();
                var actionUrl = $(this).attr("action");

                $.post(actionUrl, formValues, function(data) {
                    // Display the returned data in browser
                    console.log(data)
                });
            });
        })

    </script>
@endsection
