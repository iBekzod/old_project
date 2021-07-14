@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Report Description')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        {{-- <h1>{{$found_it_cheapers->user_id}}</h1> --}}
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%" >
            <thead>
                <tr>

                    <th>#</th>
                    <th>{{ translate('Name') }}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('comment')}}</th>
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
                    @foreach ($report_description as $key => $report_description)
                    <tr>
                        <td style="width:5%">{{$key+1}}</td>
                        {{-- <td style="width:15%">{{$found_it_cheaper->product_id}}</td> --}}
                        <td style="width:20%">
                           @if(App\User::where('id',$report_description->user_id)->exists())
                             {{App\User::where('id',$report_description->user_id)->first()->name}}
                          @else
                            <p>anonymous user</p>
                          @endif

                        </td>
                        <td style="width:10%">{{$report_description->email}}</td>
                        <td style="width:10%">
                            @php
                                $comment=$report_description->comment;
                                // dd($email);
                                if (strlen($comment)) {
                                $stringCut = substr($comment, 0,10);
                                echo $stringCut." ...";
                                }
                            @endphp
                        </td>
                        <td style="width:10%">{{$report_description->created_at}}</td>

                        <td style="width:10%">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"  href="{{route('report_description.admin_show', encrypt($report_description->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('report_description.destroy', encrypt($report_description->id))}}" title="{{ translate('Delete') }}">
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



        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
