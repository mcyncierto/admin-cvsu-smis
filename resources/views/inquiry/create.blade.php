@extends('layouts.main')

@section('content')
@if (Auth::user()->type == 'Admin')
<a type="button" class="btn btn-light mt-n4 btn-sm" href="{{ route('inquiries.index') }}">
    <i class="fas fa-angle-double-left"></i> Back to List
</a>
@endif
    <div class="container-fluid col-6">
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header" style="cursor: move;">
                <h3 class="card-title">
                    Conversation with 
                    <strong>
                        @if (Auth::user()->type == 'Student')
                            Admin
                        @else
                            {{ implode(' ', [$messages[0]->first_name, $messages[0]->middle_name, $messages[0]->last_name]) }}
                        @endif
                    </strong>
                </h3>
            </div>

            <div class="card-body">
                <div id="div-messages" class="direct-chat-messages px-4" style="height: 70vh">
                    @foreach ($messages as $message)
                        @if ((Auth::user()->type == 'Student' && Auth::user()->id == $message->created_by) ||
                            (Auth::user()->type == 'Admin' && $message->type == 'Admin'))
                            <div class="direct-chat-msg">
                                <div class="right float-right" style="width:80%">
                                    <div class="direct-chat-infos clearfix">
                                        {{-- <span class="direct-chat-name float-right">
                                            {{ implode(' ', [$message->first_name, $message->middle_name, $message->last_name]) }}
                                        </span> --}}
                                        <span class="direct-chat-timestamp float-left">
                                            {{ Carbon\Carbon::parse($message->created_at)->format('d M Y  g:i A' ) }}
                                        </span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ asset('storage/profile-pictures/' . $message->profile_picture) }}" 
                                        alt="message user image"
                                        onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}';">
            
                                    <div class="direct-chat-text">
                                        {{ $message->content }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="direct-chat-msg">
                                <div style="width:80%">
                                    <div class="direct-chat-infos clearfix">
                                        {{-- <span class="direct-chat-name float-left">
                                            {{ implode(' ', [$message->first_name, $message->middle_name, $message->last_name]) }}
                                        </span> --}}
                                        <span class="direct-chat-timestamp float-right">
                                            {{ Carbon\Carbon::parse($message->created_at)->format('d M Y  g:i A' ) }}
                                        </span>
                                    </div>
                                    <img class="direct-chat-img" src="{{ asset('storage/profile-pictures/' . $message->profile_picture) }}" 
                                        alt="message user image"
                                        onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}';">
            
                                    <div class="direct-chat-text">
                                        {{ $message->content }}
                                    </div>
                                </div>
                            </div>
                        @endif
                                
                    @endforeach
                </div>
            </div>

            <div class="card-footer">
                <form action="{{ route('inquiries.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="hidden" id="student_id" name="student_id" value="{{ $student_id }}">
                        <input type="text" maxlength="255" name="content" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button name="action" type="submit" class="btn btn-primary">Send</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()