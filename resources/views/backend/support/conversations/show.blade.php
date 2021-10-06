@extends('backend.layouts.app')

@section('content')

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="text-center text-md-left">
                    <b> {{ $conversation->sender->name }} </b> # <span class="ml-2"> {{ $conversation->created_at }}
                    </span>
                    <div class="mt-2">
                        <b>product name: </b><span> {{ $conversation->product->name }} </span>
                        <br>
                        <b>message:</b> {{$conversation->msg }}
                    </div>
                </div>
            </div>
            {{-- @dd($conversation); --}}
            <div class="card-body">
                <form action="{{ route('conversation.admin_store') }}" method="post" id="conversation-message-form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}" required>
                    {{-- <input type="hidden" name="ticket_id" value="{{$ticket->id ?? ""}}" required>
                <input type="hidden" name="status" value="{{ $ticket->status ?? ""}}" required> --}}
                    <div class="form-group">
                        <textarea class="aiz-text-editor"
                            data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]'
                            name="message" required></textarea>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-dark"
                            onclick="submit_message('pending')">{{ translate('Submit as') }}</strong></button>
                    </div>
                </form>
                <div class="pad-top">
                    <ul class="list-group list-group-flush">
                        @foreach ($conversation->messages as $conversation_messages)
                            @if (auth()->id() == $conversation_messages->user_id)
                                <li class="list-group-item" style="float: right;">
                                    <div class="card float-left  d-block" style="width: 75%;">
                                        <div class="card-header ">
                                            <div class="media mr-5 mt-4" style="float: right !important;">
                                                <a class="media-left" href="#">
                                                    @if ($conversation_messages->user->avatar_original != null)
                                                        <span class="avatar avatar-sm mr-3"><img
                                                                src="{{ uploaded_asset($conversation_messages->user->avatar_original) ?? static_asset('assets/img/placeholder.jpg') }}"></span>
                                                    @else
                                                        <span class="avatar avatar-sm mr-3"><img
                                                                src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                                                    @endif
                                                </a>
                                                <div class="media-body">
                                                    <div class="">
                                                        <span class="text-bold h6">{{ $conversation_messages->user->name }}</span>
                                                        <p class="text-muted text-sm fs-11">
                                                            {{ $conversation_messages->created_at }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="pl-2">
                                                {!! $conversation_messages->message !!}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li class="list-group-item">
                                    <div class="card " style="width: 75%;">
                                        <div class="card-header ">
                                            <div class="media float-rigth">
                                                <a class="media-left" href="#">
                                                    @if ($conversation_messages->user->avatar_original != null)
                                                        <span class="avatar avatar-sm mr-3"><img
                                                                src="{{ uploaded_asset($conversation_messages->user->avatar_original) ?? static_asset('assets/img/placeholder.jpg') }}"></span>
                                                    @else
                                                        <span class="avatar avatar-sm mr-3"><img
                                                                src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                                                    @endif
                                                </a>

                                                <div class="media-body">
                                                    <div class="">
                                                        <span class="text-bold h6">{{ $conversation_messages->user->name }}</span>
                                                        <p class="text-muted text-sm fs-11">
                                                            {{ $conversation_messages->created_at }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body float-rigth">
                                            <p class="pl-2">
                                                {!! $conversation_messages->message !!}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function submit_message() {
            if ($('textarea[name=message]').val().length > 0) {
                $('#conversation-message-form').submit();
            }
        }
    </script>
