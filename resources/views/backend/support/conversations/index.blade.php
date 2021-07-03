@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Conversations')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        <table class=" text-center pr-0 mr-0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ translate('Type') }}</th>
                    <th>{{translate('Sender')}}</th>
                    <th>{{translate('Receiver')}}</th>
                    <th>{{translate('Title')}}</th>
                    <th>{{ translate('Date') }}</th>
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

                    @foreach ($conversations as $key => $conversation)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $conversation->type }}</td>
                        <td>{{$conversation->sender_id}}</td>
                        <td>{{$conversation->receiver_id}}</td>
                        <td>{{$conversation->msg}}</td>
                        {{-- <td>
                            @if ($conversation->sender != null)
                                {{ $conversation->sender_id }}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td> --}}
                        {{-- <td>
                            @if ($conversation->receiver != null)
                                {{ $conversation->receiver_id }}
                                @if ($conversation->sender_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td> --}}
                        <td>{{ $conversation->created_at }}</td>
                        <td class="">
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
