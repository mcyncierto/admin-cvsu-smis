@extends('layouts.main')

@section('content')
    <style>
        .text-block {
            position: absolute;
            bottom: 35%;
            right: 45%;
            color: white;
        }

        h1 {
            font-size: 4vw;
        }

        .center-image {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            vertical-align: middle;
        }
    </style>
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
                        <button type="button" class="btn btn-block btn-success" data-toggle="modal"
                            data-target="#add-announcement-modal">
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
                                <span class="time"><i class="fas fa-clock"></i>
                                    {{ Carbon\Carbon::parse($announcement->updated_at)->diffForHumans() }}</span>
                                <div class="timeline-header">
                                    <h3>{{ $announcement->title }}</h3>
                                    <span>&nbsp;</span>

                                    @if (Auth::user()->type == 'Admin')
                                        <div class="row float-right mt-n3 mr-2">
                                            <div class="mr-2">
                                                <a title="Edit Record" type="button"
                                                    href="{{ route('announcements.edit', $announcement->id) }}"
                                                    class="btn btn-block btn-outline-warning btn-sm"
                                                    style="max-width: 35px">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('announcements.destroy', $announcement->id) }}"
                                                method="post" id="formDeleteAnnouncement{{ $announcement->id }}">
                                                <button title="Delete Record" type="button"
                                                    class="btn btn-block btn-outline-danger btn-sm" style="width: 35px"
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

                                <div class="timeline-body">
                                    {!! $announcement->content !!}
                                </div>


                                <!-- Carousel Modal -->
                                <div class="modal fade" id="modal-default-{{ $announcement->id }}" data-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height:100%">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#212121">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span style="color: white" aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="height:80vh; background-color:#616161">
                                                <div id="carouselExampleIndicators-{{ $announcement->id }}"
                                                    class="carousel slide" data-ride="carousel"
                                                    style="height: 100%; display: flex !important">
                                                    <ol class="carousel-indicators">
                                                        @foreach ($announcement->images as $key => $val)
                                                            <li data-target="#carouselExampleIndicators-{{ $announcement->id }}"
                                                                data-slide-to="{{ $key }}"></li>
                                                        @endforeach
                                                    </ol>

                                                    <div class="carousel-inner" style="margin: auto !important;">
                                                        @foreach ($announcement->images as $key => $val)
                                                            <div class="carousel-item @if ($key == 0) active @endif" style="height: 70vh">
                                                                <img class="d-block center-image" style="max-width: 100%; width: auto; height: 100%"
                                                                    src="{{ asset('storage/announcements/' . $announcement->id . '/' . $announcement->images[$key]->image_name) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <a class="carousel-control-prev"
                                                        href="#carouselExampleIndicators-{{ $announcement->id }}"
                                                        role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <div>
                                                        <a class="carousel-control-next"
                                                            href="#carouselExampleIndicators-{{ $announcement->id }}"
                                                            role="button" data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="background-color:#212121">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Photo Gallery -->
                                <div data-toggle="modal" data-target="#modal-default-{{ $announcement->id }}" style="cursor: pointer;">
                                    @if ($announcement->images)
                                        @if (count($announcement->images) == 2)
                                            <div class="pb-4" style="text-align:center; margin: 5px">
                                                <div class="row">
                                                    @foreach ($announcement->images as $image)
                                                        <div style="width:50%; float:left; padding: 5px">
                                                            <img class="img-fluid" style="width:100%"
                                                                src="{{ asset('storage/announcements/' . $announcement->id . '/' . $image->image_name) }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif (count($announcement->images) >= 3)
                                            <div class="pb-4" style="text-align:center; margin: 5px">
                                                <div class="row">
                                                    <div style="width:60%; float:left; padding: 5px;display: flex;">
                                                        <img class="img-fluid" style="width:100%;margin: auto;"
                                                            src="{{ asset('storage/announcements/' . $announcement->id . '/' . $announcement->images[0]->image_name) }}">
                                                    </div>

                                                    <div style="width:40%; float:left; padding: 5px">
                                                        <div style="width:100%; float:top; padding: 5px">
                                                            <img class="img-fluid" style="width:100%"
                                                                src="{{ asset('storage/announcements/' . $announcement->id . '/' . $announcement->images[1]->image_name) }}">
                                                        </div>
                                                        <div
                                                            style="width:100%; float:top; padding: 5px;position: relative;;">
                                                            <img class="img-fluid"
                                                                style="width:100%;@if (count($announcement->images) > 3) filter: brightness(50%) @endif"
                                                                src="{{ asset('storage/announcements/' . $announcement->id . '/' . $announcement->images[2]->image_name) }}">

                                                            @if (count($announcement->images) > 3)
                                                                <div class="text-block">
                                                                    <h1>+{{ count($announcement->images) - 3 }}</h1>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($announcement->images as $image)
                                                <div class="pb-4" style="text-align:center; padding: 5px">
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/announcements/' . $announcement->id . '/' . $image->image_name) }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif

                                </div>
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
