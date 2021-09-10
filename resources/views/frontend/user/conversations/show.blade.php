@extends('frontend.layouts.seller')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-start">
                @include('frontend.inc.user_side_nav')

                <div class="aiz-user-panel">
                    <div class="aiz-titlebar mt-2 mb-4">
                        <div class="h6">
                            <span>{{ translate('Conversations With ') }}</span>
                            {{-- @if ($conversation->sender_id == Auth::user()->id && $conversation->receiver->shop != null)
                                <a href="{{ route('shop.visit', $conversation->receiver->shop->slug) }}" class="">{{ $conversation->receiver->shop->name }}</a>
                            @endif --}}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-block" >
                            <div class="row">
                                <div class="col-lg-3">
                                    <span class="avatar avatar-sm flex-shrink-1 ">
                                        <img @if ($conversation->sender->avatar_original == null) src="{{ static_asset('assets/img/avatar-place.png') }}" @else src="{{ uploaded_asset($conversation->sender->avatar_original) }}" @endif class="rounded-circle" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                    </span>
                                    <div class="col-auto pl-2">
                                        <p>
                                            <span
                                                class="fw-600">{{ $conversation->sender->name ?? ' sender name not found' }}</span>
                                            <br>
                                            <span class="opacity-50">
                                                {{ $conversation->created_at ?? ' data not fount' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="selection-header">
                                        <h5>
                                            {{ translate('Between you and') }}
                                            @if ($conversation->sender_id == Auth::user()->id)
                                                {{ $conversation->receiver->name }}
                                            @else
                                                {{ $conversation->sender->name }}
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="selection-body">
                                       <b>
                                           product name:
                                       </b>
                                       <span> {{ $conversation->product->name }}</span>
                                       <br>
                                       <b>message:</b>
                                        <span>#{{ $conversation->msg }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($conversation->messages as $message)
                                    <li class="list-group-item px-0">
                                        <div class="media mb-2">
                                            <img class="avatar avatar-xs mr-3" @if ($message->user != null) src="{{ uploaded_asset($message->user->avatar_original) ?? static_asset('assets/img/placeholder.jpg') }}" @endif
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                            <div class="media-body">
                                                <h6 class="mb-0 fw-600">
                                                    @if ($message->user != null)
                                                        {{ $message->user->name }}
                                                    @endif
                                                </h6>
                                                <p class="opacity-50">{{ $message->created_at }}</p>
                                            </div>
                                        </div>
                                        <p>
                                            {{ $message->message }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            <form class="pt-4" action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" name="message"
                                        placeholder="{{ translate('Type your reply') }}" required></textarea>
                                </div>
                                <div class="form-group mb-0 text-right">
                                    <button type="submit" class="btn btn-primary">{{ translate('Send') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function refresh_messages() {
            $.post('{{ route('conversations.refresh') }}', {
                _token: '{{ @csrf_token() }}',
                id: '{{ encrypt($conversation->id) }}'
            }, function(data) {
                $('#messages').html(data);
            })
        }

        refresh_messages(); // This will run on page load
        setInterval(function() {
            refresh_messages() // this will run after every 5 seconds
        }, 4000);
    </script>
@endsection
