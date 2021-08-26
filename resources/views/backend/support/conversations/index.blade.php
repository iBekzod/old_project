@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Conversations')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%">
            <thead>
                <tr>
                    <th>#</th>
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
                        <td style="width: 3%">{{$key+1}}</td>
                        <td style="width: 10%">
                            @if(App\User::where('id',$conversation->sender_id)->exists())
                              {{ App\User::where('id',$conversation->sender_id)->first()->name}}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 11%">
                            @if(App\Product::where('id',$conversation->receiver_id)->exists())
                            {{ App\Product::where('id',$conversation->receiver_id)->first()->user->name}}
                                @if ($conversation->sender_viewed == 0)
                                <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 20%">
                            @php
                            $string=$conversation->msg;
                            // dd($string);
                                 if (strlen($string)>20) {
                             $string = substr($string, 0,20);
                             echo $string." ...";
                              }else {
                                   echo $string;
                              }
                            @endphp

                            {{-- @if ($conversation->sender != null)
                                {{ $conversation->sender->name }}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($conversation->receiver != null)
                                {{ $conversation->receiver->name }}
                                @if ($conversation->sender_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td> --}}
                        <td style="width: 15%">{{ $conversation->created_at }}</td>
                        <td style="width: 8%">
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
