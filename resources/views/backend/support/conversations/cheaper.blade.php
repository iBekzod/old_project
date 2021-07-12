@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Conversations')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        <h1>{{$found_it_cheapers->user_id}}</h1>
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%" border="1px">
            <thead>
                <tr>

                    <th>#</th>
                    <th>{{ translate('User_id') }}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('Links')}}</th>
                    <th>{{translate('Price')}}</th>
                    {{-- <th>{{ translate('Date') }}</th> --}}
                    {{-- <th>{{translate('Receiver')}}</th>
                    <th width="10%">{{translate('Options')}}</th> --}}


                    {{-- <th>{{ translate('Date') }}</th>
                    <th>{{translate('Title')}}</th>
                    <th>{{translate('Sender')}}</th>
                    <th>{{translate('Receiver')}}</th>
                    <th width="10%">{{translate('Options')}}</th> --}}
                </tr>
            </thead>

            <tbody>

                {{-- @dd($conversations) --}}
                    @foreach ($found_it_cheaper as $key => $found_it_cheapers)
                    <tr>
                        <td style="width:10%">{{$key+1}}</td>
                        <td style="width:15%">{{$found_it_cheapers}}</td>
                        <td style="width:15%">werertr</td>
                        <td style="width:15%"></td>
                        <td style="width:15%"></td>
                        <td style="width:15%">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('conversations.admin_show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('conversations.destroy', encrypt($conversation->id))}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>



        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
