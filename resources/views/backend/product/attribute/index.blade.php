@extends('backend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center d-flex justify-content-between">
            <h1 class="h3">@if(isset($branch)){{$branch->getTranslation('name')}}@else{{translate('All Attributes')}}@endif</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                Add New Branch
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Attributes')}}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name')}}</th>
                            <th>{{ translate('Combination')}}</th>
                            <th class="text-right">{{ translate('Options')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributes as $key => $attribute)
                            <tr>
                                <td>{{ ($key+1) + ($attributes->currentPage() - 1)*$attributes->perPage() }}</td>
                                {{--                                <td>{{$key+1}}</td>--}}
                                <td>{{$attribute->getTranslation('name')}}</td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_combination_status(this)" value="{{ $attribute->id }}"
                                               type="checkbox" @if($attribute->combination == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                       title="{{ translate('Edit') }}" data-toggle="modal"
                                       data-target="#EditModal_{{$attribute->id}}">
                                        <i class="las la-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                       data-href="{{route('attributes.destroy', $attribute->id)}}"
                                       title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
{{--                                    <a href="{{route('attributes.edit.categories', $attribute->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm"--}}
{{--                                       title="{{ translate('Categories') }}">--}}
{{--                                        <i class="las la-asterisk"></i>--}}
{{--                                    </a>--}}

{{--                                    <a href="{{route('attributes.edit.characteristics', $attribute->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm"--}}
{{--                                       title="{{ translate('Characteristics') }}">--}}
{{--                                        <i class="las la-link"></i>--}}
{{--                                    </a>--}}
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="#"
                                       title="{{ translate('Characteristics') }}" data-toggle="modal"
                                       data-target="#AttributesModal" onclick="update_attribute_characteristics({{$attribute->id}})">
                                        <i class="las la-link"></i>
                                    </a>

                                    <form class="p-4" action="{{ route('attributes.update', $attribute->id) }}"
                                          method="POST">
                                        @csrf
                                        <div class="modal fade" id="EditModal_{{$attribute->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{translate('Attribute Information')}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-from-label"
                                                                   for="name">{{translate('Name')}} <i
                                                                    class="las la-language text-danger"
                                                                    title="{{translate('Translatable')}}"></i></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" placeholder="{{translate('Name')}}"
                                                                       name="name" class="form-control"
                                                                       required
                                                                       value="{{ $attribute->getTranslation('name') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{translate('Close')}}</button>
                                                        <button type="submit"
                                                                class="btn btn-primary">{{translate('Save')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $attributes->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <form action="{{ route('attributes.store') }}" method="POST">
        @if(isset($branch))<input type="hidden" name="branch_id" value="{{ $branch->id }}">@endif
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('Add New Attribute') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{translate('Name')}}</label>
                            <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('attributes.edit.characteristics') }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal fade" id="AttributesModal" tabindex="-1"
             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLongTitle">{{translate('Characteristics')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" id="attribute_id" value="">
                                <select class="form-control js-example-basic-multiple"
                                        multiple name="characteristics[]"
                                        id="characteristics">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{translate('Close')}}</button>
                            <button type="submit"
                                    class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_combination_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('attributes.combination') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Attribute combination updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
        function onCloseModal(){
            $('#characteristic_id').html(" ")
        }
        function update_attribute_characteristics(id){
            $('#attribute_id').val(id)
            $.ajax({
                type:'GET',
                url:'{{ route('attributes.edit.characteristics') }}',
                data:{
                    attribute_id: id
                },
                success:function(data){
                    // console.log(data)
                    $('#characteristics').html(" ")
                    if(data.success){
                        $('#characteristics').html(data.data)
                        $('#attribute_id').val(id)
                        // alert($('#attribute_id').val())
                        $('.js-example-basic-multiple').select2({
                            tags: true
                        });
                    }
                }
            });
        }
    </script>
@endsection
