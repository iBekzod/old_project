@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{translate('Add New Product')}}</h5>
    </div>
    <div class="col-md-12 mx-auto">
        <form class="form form-horizontal mar-top" action="{{route('products.store')}}" method="POST"
              enctype="multipart/form-data" id="choice_form">
            @csrf
            <input type="hidden" name="added_by" value="admin">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Product Name')}} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name"
                                   placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                        </div>
                    </div>
                    <div class="form-group row" id="element">
                        <label class="col-md-3 col-from-label">{{translate('Element')}} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="element_id" id="element_id"
                                    data-live-search="true" required>
                                @foreach ($elements as $element)
                                     <option value="{{ $element->id }}">{{ $element->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sku_combination" id="sku_combination">
                </div>
            </div>
            <div class="mb-3 text-right">
                <button type="submit" name="button" class="btn btn-primary">{{ translate('Save Product') }}</button>
            </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function delete_variant(em) {
            $(em).closest('.variant').remove();
        }
        $('#element_id').on('change', function () {
            $('#customer_choice_options').html(null);
            $.ajax({
                type: "GET",
                url: '{{ route('products.make_combination') }}',
                data: $('#choice_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data);
                }
            });
        });
    </script>
@endsection
