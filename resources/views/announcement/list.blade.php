@extends('layouts.main')

@section('content')
    @include('announcement.add_modal')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Announcements</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container-fluid">
        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-12">
                @if (Auth::user()->type == 'Admin')
                    <div class="float-right mb-3">
                        <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#add-announcement-modal">
                            <i class="fas fa-plus-circle"></i>
                            Add Announcement
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                <!-- The time line -->
                <div class="timeline">
                    <!-- timeline item -->
                    @foreach ($announcements as $announcement)
                        <div>
                            @if ($announcement->type == 'general')
                                <i class="fas fa-info-circle bg-blue"></i>
                            @else
                                <i class="far fa-calendar-check bg-green"></i>
                            @endif
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ Carbon\Carbon::parse($announcement->created_at)->diffForHumans()}}</span>
                                <div class="timeline-header">
                                    <h3>{{ $announcement->title }}</h3>
                                    <small>{{ Str::ucfirst($announcement->type) }}</small>

                                    @if (Auth::user()->type == 'Admin')
                                    <div class="row float-right mt-n3 mr-2">
                                        <button title="Edit Record" type="button" class="btn btn-block btn-outline-warning btn-sm mr-2" style="width: 35px"
                                            data-toggle="modal" data-target="#edit-announcement-modal-{{ $announcement->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="post"
                                            id="formDeleteAnnouncement{{ $announcement->id }}">
                                            <button title="Delete Record" type="button" class="btn btn-block btn-outline-danger btn-sm" style="width: 35px"
                                                onclick="confirmSubmit('delete', 'formDeleteAnnouncement',
                                                '{{ $announcement->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @method('delete')
                                            @csrf
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                @include('announcement.edit_modal')
                                
                                <div class="timeline-body">
                                    {{ $announcement->content }}
                                </div>
                                @if (isset($announcement->photo))
                                    <div class="pb-4" style="text-align:center">
                                        <img class="img-fluid"
                                            src="{{ asset('storage/announcements/' . $announcement->photo) }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <!-- END timeline item -->
                    <!-- timeline item -->
                </div>
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $announcements->links() }}</span>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->
    @endsection
