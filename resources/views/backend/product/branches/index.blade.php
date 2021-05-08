@extends('backend.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center d-flex justify-content-between">
            <h1 class="h3">{{translate('All Branches')}}</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                Add New Branch
            </button>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Branches')}}</h5>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Name')}}</th>
                            <th class="text-right">{{ translate('Options')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branches as $key => $branch)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$branch->getTranslation('name')}}</td>
                                <td class="text-right">
                                    <a data-toggle="modal" data-target="#EditModal_{{$branch->id}}"
                                       class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('branches.edit', ['id'=>$branch->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}"
                                       title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                       data-href="{{route('branches.destroy', $branch->id)}}"
                                       title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    <a href="{{route('branches.arributes', $branch->id)}}"
                                       class="btn btn-soft-warning btn-icon btn-circle btn-sm "
                                       title="{{ translate('View Attributes') }}">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <form action="{{ route('branches.store') }}" method="POST">
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ translate('Add New Branch') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">{{translate('Name')}}</label>
                                <input type="text" placeholder="{{ translate('Name')}}" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
