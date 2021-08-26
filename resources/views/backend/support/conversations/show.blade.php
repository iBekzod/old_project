@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="text-center text-md-left">
                <span> {{ $conversation->sender->name }} </span> #  <span class="ml-2"> {{ $conversation->created_at }} </span>
               <div class="mt-2">
                <b>product name: </b><span> {{ $conversation->product->name }} </span>
                   <br>
                <b>message:</b>   {{json_decode($conversation->msg)->content}}
               </div>
            </div>
        </div>
        {{-- <div class="card-header">
               <h5 class="card-title">full information</h5>
               <ul class="list-group list-group-flush">
                    <li class="list-group-item mb-2">
                        <b>created ad :</b>
                        {{ $conversation->created_at }}
                    </li>
                    <div class="card">
                        <div class="card-header text-center">
                           <h5>
                                <b>User name: </b>
                                {{$conversation->sender->name}}
                           </h5>
                        </div>
                        <div class="card-body">
                            <b>product name: </b>
                            {{$conversation->product->name}} <br>
                            {{$conversation->sender->name}} <br>
                            {{json_decode($conversation->msg)->content}}
                        </div>
                    </div>
               </ul>
        </div> --}}
         {{-- @dd($conversation); --}}
        <div class="card-body">
            <form action="{{ route('conversation.admin_store') }}" method="post" id="ticket-reply-form" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="ticket_id" value="{{$ticket->id ?? ""}}" required>
                <input type="hidden" name="status" value="{{ $ticket->status ?? ""}}" required> --}}
                <div class="form-group">
                    <textarea class="aiz-text-editor" data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]' name="reply" required></textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="attachments" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-dark" onclick="submit_reply('pending')">{{ translate('Submit as') }}</strong></button>
                </div>
            </form>
            <div class="pad-top">
                <ul class="list-group list-group-flush">
                    @foreach($conversation->messages as $conversation_messages)
                        @if(auth()->id()==$conversation_messages->user_id)
                            <li class="list-group-item" style="float: right;">
                                <div class="media float-right">
                                    <a class="media-left" href="#">
                                        @if($conversation_messages->user->avatar_original != null)
                                            <span class="avatar avatar-sm mr-3"><img src="{{ uploaded_asset($conversation_messages->user->avatar_original)??static_asset('assets/img/placeholder.jpg') }}"></span>
                                        @else
                                            <span class="avatar avatar-sm mr-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                                        @endif
                                    </a>

                                    <div class="media-body">
                                        <div class="">
                                            <span class="text-bold h6">{{ $conversation->sender->name }}</span>
                                            <p class="text-muted text-sm fs-11">{{$conversation_messages->created_at}}</p>
                                        </div>
                                        <p>
                                            {{$conversation_messages->message}}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="list-group-item">
                                <div class="media">
                                    <a class="media-left" href="#">
                                        @if($conversation_messages->user->avatar_original != null)
                                            <span class="avatar avatar-sm mr-3"><img src="{{ uploaded_asset($conversation_messages->user->avatar_original)??static_asset('assets/img/placeholder.jpg') }}"></span>
                                        @else
                                            <span class="avatar avatar-sm mr-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                                        @endif
                                    </a>

                                    <div class="media-body">
                                        <div class="">
                                            <span class="text-bold h6">{{ $conversation->sender->name }}</span>
                                            <p class="text-muted text-sm fs-11">{{$conversation_messages->created_at}}</p>
                                        </div>
                                        <p>
                                            {{$conversation_messages->message}}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                    <li class="list-group-item">
                        <div class="media">
                            <a class="media-left" href="#">
                                @if($conversation_messages->user->avatar_original != null)
                                    <span class="avatar avatar-sm m-3"><img src="{{ uploaded_asset($conversation_messages->user->avatar_original)??static_asset('assets/img/placeholder.jpg') }}"></span>
                                @else
                                    <span class="avatar avatar-sm m-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                                @endif
                            </a>
                            <div class="media-body">
                                <div class="comment-header">
                                    <span class="text-bold h6 text-muted">{{ $conversation->sender->name }}</span>
                                    <p class="text-muted text-sm fs-11">{{ $conversation_messages->created_at }}</p>
                                </div>
                                <p>
                                    {{$conversation_messages->message}}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>



@endsection
