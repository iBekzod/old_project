@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Support Service')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{translate('Phone number')}}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('message')}}</th>
                    <th>{{ translate('Date') }}</th>
                    {{-- <th>{{translate('Receiver')}}</th>
                    <th width="10%">{{translate('Options')}}</th> --}}
                </tr>
            </thead>

            <tbody>
                @foreach ($support_service as $key => $support_service)
                    <tr>
                        <td style="width:5%">{{$key+1}}</td>
                        {{-- <td style="width:15%">{{$found_it_cheaper->product_id}}</td> --}}
                        <td style="width:15%">
                            {{$support_service->name}}
                        {{-- @if(App\User::where('id',$support_service->user_id)->exists())
                            {{App\User::where('id',$support_service->user_id)->first()->name}}
                        @else
                            <p>anonymous user</p>
                        @endif --}}

                        </td>
                        <td style="width:10%">{{$support_service->phone}}</td>
                        <td style="width:10%">{{$support_service->email}}</td>
                        <td style="width:10%">
                            @php
                                $message=$support_service->message;
                                // dd($email);
                                if (strlen($message)) {
                                $stringCut = substr($message, 0,10);
                                echo $stringCut." ...";
                                }
                            @endphp
                        </td>
                        <td style="width:10%">{{$support_service->created_at}}</td>

                        <td style="width:10%">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"  href="{{route('support_service.admin_show', encrypt($support_service->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('support_service.destroy', encrypt($support_service->id))}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                        {{-- <td style="width:15%">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('conversations.admin_show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('conversations.destroy', encrypt($conversation->id))}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td> --}}
                    </tr>
               @endforeach
            </tbody>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
