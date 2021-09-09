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
                            <b>Product name: </b>
                            @if(App\Product::where('id',$found_it_cheaper->product_id)->exists())
                              {{App\Product::where('id',$found_it_cheaper->product_id)->first()->name}}
                           @endif
                        </li>
                        <li class="list-group-item">
                            <b>Email: </b>
                            {{$found_it_cheaper->email}}
                        </li>
                        <li class="list-group-item">
                            <b>Links: </b>
                            {{$found_it_cheaper->links}}
                        </li>
                        <li class="list-group-item mb-2">
                            <b>Price :</b>
                            {{ $found_it_cheaper->price }}
                        </li>
                        <li class="list-group-item mb-2">
                            <b>Currency: </b>
                            @if (App\Currency::where('id',$found_it_cheaper->currency_id)->exists())
                             {{App\Currency::where('id', $found_it_cheaper->currency_id)->first()->symbol}}
                             @endif
                        </li>
                </ul>
        </div>
    </div>
</div>

@endsection
