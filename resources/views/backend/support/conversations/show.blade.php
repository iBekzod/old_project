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

                @foreach ($conversation->messages as $conversation_messages)
                <li>
                    {{ $conversation_messages->user_id}}
                </li>

                @endforeach

                <ul class="list-group list-group-flush">
                        <li class="list-group-item mb-2">
                            <b>created ad :</b>
                            {{ $conversation->created_at }}
                        </li>
                            <div class="card">
                                <div class="card-header text-center">
                                   <h5>
                                        <b>User name: </b>
                                        {{$conversation->sender_id}}
                                   </h5>
                                </div>
                                <div class="card-body">
                                    <b>product name: </b>
                                    {{$conversation->product->name}} <br>
                                    {{json_decode($conversation->msg)->content}}
                                </div>
                            </div>
                </ul>
        </div>
    </div>
</div>
{{--
<div class="pad-top">
    <ul class="list-group list-group-flush">
        @foreach($conversation as $conversations)
        @dd($conversations['receiver_id'])
            <li class="list-group-item">
                <div class="media">
                    <a class="media-left" href="#"> --}}
                        {{-- @if($ticketreply->user->avatar_original != null)
                            <span class="avatar avatar-sm mr-3"><img src="{{ uploaded_asset($ticketreply->user->avatar_original)??static_asset('assets/img/placeholder.jpg') }}"></span>
                        @else
                            <span class="avatar avatar-sm mr-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                        @endif --}}
                        {{-- <span class="avatar avatar-sm mr-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                    </a>
                    <div class="media-body">
                        <div class="">
                            <span class="text-bold h6">{{ $conversations->user->name }}</span>
                            <p class="text-muted text-sm fs-11">{{$ticketreply->created_at}}</p>
                        </div>
                        <div class="">

                            @php echo $ticketreply->reply; @endphp

                            <div class="mt-3">
                            @foreach ((explode(",",$ticketreply->files)) as $key => $file)
                                @php $file_detail = \App\Upload::where('id', $file)->first(); @endphp
                                @if($file_detail != null)
                                    <a href="{{ uploaded_asset($file) }}" download="" class="badge badge-lg badge-inline badge-light mb-1">
                                        <i class="las la-paperclip mr-2">{{ $file_detail->file_original_name.'.'.$file_detail->extension }}</i>
                                    </a>
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        <li class="list-group-item">
            <div class="media">
                <a class="media-left" href="#">
                    @if($ticket->user->avatar_original != null)
                        <span class="avatar avatar-sm m-3"><img src="{{ uploaded_asset($ticket->user->avatar_original)??static_asset('assets/img/placeholder.jpg') }}"></span>
                    @else
                        <span class="avatar avatar-sm m-3"><img src="{{ static_asset('assets/img/avatar-place.png') }}"></span>
                    @endif
                </a>
                <div class="media-body">
                    <div class="comment-header">
                        <span class="text-bold h6 text-muted">{{ $ticket->user->name }}</span>
                        <p class="text-muted text-sm fs-11">{{ $ticket->created_at }}</p>
                    </div>
                    <p>
                        @php echo $ticket->details; @endphp
                        <br>
                        @foreach ((explode(",",$ticket->files)) as $key => $file)
                            @php $file_detail = \App\Upload::where('id', $file)->first(); @endphp
                            @if($file_detail != null)
                                <a href="{{ uploaded_asset($file) }}" download="" class="badge badge-lg badge-inline badge-light mb-1">
                                    <i class="las la-download text-muted">{{ $file_detail->file_original_name.'.'.$file_detail->extension }}</i>
                                </a>
                                <br>
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </li>
    </ul>
</div> --}}

@endsection
