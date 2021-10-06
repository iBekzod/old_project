@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Found it cheaper')}}</h5>
    </div>
    <div class="card-body pr-0 mr-0">
        {{-- <h1>{{$found_it_cheapers->user_id}}</h1> --}}
        <table class=" text-center pr-0 mr-0" cellspacing="0"  width="100%" >
            <thead>
                <tr>

                    <th>#</th>
                    <th>{{ translate('Product name') }}</th>
                    <th>{{translate('Email')}}</th>
                    <th>{{translate('Links')}}</th>
                    <th>{{translate('Price')}}</th>
                    <th>{{ translate('Currency') }}</th>
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
                    @foreach ($found_it_cheapers as $key => $found_it_cheaper)
                    <tr>
                        <td style="width:5%">{{$key+1}}

                        </td>
                        {{-- <td style="width:15%">{{$found_it_cheaper->product_id}}</td> --}}
                        <td style="width:20%">
                           @if(App\Product::where('id',$found_it_cheaper->product_id)->exists())
                            @php
                              $product_name=App\Product::where('id',$found_it_cheaper->product_id)->first()->name;
                              if (strlen($product_name)>30){
                                  $stringCut=substr($product_name, 0,30);
                                  echo $stringCut." ...";
                              }
                            @endphp
                           @endif
                           @if ($found_it_cheaper->viewed == null)
                           <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                           @endif
                        </td>
                        <td style="width:10%">{{$found_it_cheaper->email}}</td>
                        <td style="width:10%">
                            @php
                                $links=$found_it_cheaper->links;
                                // dd($email);
                                if (strlen($links)) {
                                $stringCut = substr($links, 0,10);
                                echo $stringCut." ...";
                                }
                            @endphp
                        </td>
                        <td style="width:10%">{{$found_it_cheaper->price}}</td>
                        {{-- <td style="width:15%">{{$found_it_cheaper->currency_id}}</td> --}}
                        <td style="width:10%">
                             @if (App\Currency::where('id',$found_it_cheaper->currency_id)->exists())
                             {{App\Currency::where('id', $found_it_cheaper->currency_id)->first()->symbol}}
                             @endif
                        </td>
                        <td style="width: 15%"> {{$found_it_cheaper->created_at}}</td>
                        <td style="width:10%">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('found_it_cheapers.admin_show', encrypt($found_it_cheaper->id))}}"  title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('found_it_cheapers.destroy', encrypt($found_it_cheaper->id))}}"  title="{{ translate('Delete') }}">
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

{{--
@foreach ($conversations as $key => $conversation)
<tr>
    <td style="width: 3%">{{$key+1}}</td>
    <td style="width: 10%">
        @if(App\User::where('id',$conversation->sender_id)->exists())
          {{ App\User::where('id',$conversation->sender_id)->first()->name}}
        @endif
    </td>
    <td style="width: 11%">@if(App\Product::where('id',$conversation->receiver_id)->exists()){{ App\Product::where('id',$conversation->receiver_id)->first()->user->name}}@endif</td>
    <td style="width: 20%">
        @php
        $string=json_decode($conversation->msg, true)['content'];
        // dd($string);
             if (strlen($string)>30) {
         $stringCut = substr($string, 0,30);
          }
           echo $stringCut." ...";

        @endphp

       </td> --}}
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
    {{-- <td style="width: 15%">{{ $conversation->created_at }}</td>
    <td style="width: 8%">
        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('conversations.admin_show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
            <i class="las la-eye"></i>
        </a>
        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('conversations.destroy', encrypt($conversation->id))}}" title="{{ translate('Delete') }}">
            <i class="las la-trash"></i>
        </a>
    </td>
</tr>
@endforeach --}}
