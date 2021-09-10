@extends('frontend.layouts.seller')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')
                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <b class="h4">{{ translate('Conversations') }}</b>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($conversations as $key => $conversation)
                                    @if ($conversation->receiver_id != null && $conversation->sender_id != null)
                                        <li class="list-group-item px-0">
                                            <div class="row gutters-10">
                                                <div class="col-auto">
                                                    <div class="media">
                                                        <span class="avatar avatar-sm flex-shrink-0">
                                                            <img @if ($conversation->sender->avatar_original == null) src="{{ static_asset('assets/img/avatar-place.png') }}" @else src="{{ uploaded_asset($conversation->sender->avatar_original) }}" @endif class="rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-auto col-lg-3 pl-2">
                                                    <p>
                                                        <span
                                                            class="fw-600">{{ $conversation->sender->name ?? ' sender name not found' }}</span>
                                                        <br>
                                                        <span class="opacity-50">
                                                            {{ $conversation->created_at ?? ' data not fount' }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-lg">
                                                    <p class="mt-2">
                                                        {{-- {{ $conversation->msg }} --}}
                                                        @php
                                                            $string = $conversation->msg;
                                                            if (strlen($string) > 20) {
                                                                $string = substr($string, 0, 70);
                                                                echo $string . ' ...';
                                                            } else {
                                                                echo $string;
                                                            }
                                                        @endphp
                                                        @if ($conversation->receiver_viewed === 0)
                                                            <span
                                                                class="badge badge-inline badge-danger ml-3 px-2">{{ translate('New') }}
                                                            </span>

                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-1 ">
                                                    <p class="mt-0">
                                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"  href="{{route('conversations.show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
                                                            <i class="las la-eye"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="aiz-pagination">
                      	{{ $conversations->links() }}
                	</div>
                </div>
            </div>
        </div>
    </section>

@endsection



{{-- @extends('backend.layouts.app')

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
            </thead>
            <tbody>
                    @foreach ($conversations as $key => $conversation)
                    <tr>
                        <td style="width: 3%">{{$key+1}}</td>
                        <td style="width: 10%">
                            @if (App\User::where('id', $conversation->sender_id)->exists())
                              {{ App\User::where('id',$conversation->sender_id)->first()->name}}
                                @if ($conversation->receiver_viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @else
                            {{ "user name not found" }}
                            @endif
                        </td>
                        <td style="width: 11%">
                            @if (App\Product::where('id', $conversation->receiver_id)->exists())
                            {{ App\Product::where('id',$conversation->receiver_id)->first()->user->name}}
                                @if ($conversation->sender_viewed == 0)
                                <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                            @endif
                        </td>
                        <td style="width: 20%">
                            @php
                            $string=$conversation->msg;
                                 if (strlen($string)>20) {
                             $string = substr($string, 0,50);
                             echo $string." ...";
                              }else {
                                   echo $string;
                              }
                            @endphp

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
@endsection --}}
