@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
               <h5 class="card-title">full information</h5>

            {{-- <h5 class="card-title">#{{ $conversation->title }} (Between @if($conversation->sender != null) {{ $conversation->sender->name }} @endif and @if($conversation->receiver != null) {{ $conversation->receiver->name }} @endif)
            </h5> --}}
        </div>
         {{-- @dd($conversation); --}}
         <div class="card-body">
             {{-- @dd($found_it_cheaper); --}}
                <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <b> Name: </b>
                            @if(App\User::where('id',$report_description->user_id)->exists())
                              {{App\User::where('id',$report_description->user_id)->first()->name}}
                            @else
                                <p>anonymous user</p>
                           @endif
                        </li>
                        <li class="list-group-item">
                            <b>Email: </b>
                            {{$report_description->email}}
                        </li>
                        <li class="list-group-item">
                            <b>Comment: </b>
                            {{$report_description->comment}}
                        </li>
                </ul>

        </div>



    </div>
</div>

@endsection
