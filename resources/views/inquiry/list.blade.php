@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inquiries</h3>

                    <form action="{{ route('inquiries.index') }}" method="post" id="formSearchInquiry" class="card-tools">
                        @method('get')
                        @csrf
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" value="{{ $search }}" name="search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="font-size: 16px">
                    <table class="table table-head-fixed table-hover">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>Message</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @foreach ($messages as $message)
                                <tr onClick="location.href='{{ route('inquiries.create', $message->student_id) }}'"
                                    @if (!$message->is_read && $message->type <> 'Admin')
                                        class="font-weight-bold" style="background-color: #f5f5f5"
                                    @endif
                                >
                                    <td>{{ implode(' ', [$message->first_name, $message->middle_name, $message->last_name])}}</td>
                                    <td style="white-space: nowrap;
                                        overflow: hidden;text-overflow: ellipsis;
                                        max-width: 25ch;">
                                        {{ $message->content }}
                                    </td>
                                    <td class="text-right pr-5">{{ Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</td>
                                    {{-- @include('user.edit_modal') --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $messages->links() }}</span>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
