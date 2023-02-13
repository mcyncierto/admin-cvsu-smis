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
    @include('photo-catalog.add_modal')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Photo Catalog</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container-fluid">
        <!-- Timelime example  -->
        <div class="row">
            <div class="col-md-12">
                @if (Auth::user()->type == 'Admin' || Auth::user()->type == 'Cashier')
                    <div class="float-right mb-3 mr-4">
                        <button type="button" class="btn btn-block btn-success" data-toggle="modal"
                            data-target="#add-photo-catalog-modal">
                            <i class="fas fa-plus-circle"></i>
                            Add Photo Catalog
                        </button>
                    </div>
                @endif
            </div>

            <div class="col-md-12">
                <div class="timeline">
                    <div>
                        <i class="fas fa-search bg-blue"></i>
                        <div class="timeline-item">
                            <div class="timeline-header">
                                <form action="{{ route('photo-catalog.index') }}" method="post"
                                    id="formSearchPhotoCatalog">
                                    @method('get')
                                    @csrf
                                    <div class="row" style="width:100%">
                                        <div class="col-2">
                                            <select id="filter_school_year" name="filter_school_year"
                                                class="form-control-sm" style="width:100%">
                                                <option value="" selected>Filter School Year here</option>
                                                @foreach ($school_years as $school_year)
                                                    <option @if ($filter_school_year == $school_year) selected @endif
                                                        value="{{ $school_year }}">{{ $school_year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <select id="filter_semester" name="filter_semester" class="form-control-sm"
                                                style="width:100%">
                                                <option value="" selected>Filter Semester here</option>
                                                @foreach ($semesters as $semester)
                                                    <option @if ($filter_semester == $semester['id']) selected @endif
                                                        value="{{ $semester['id'] }}">
                                                        {{ $semester['semester_name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" value="{{ $search }}" name="search"
                                                class="form-control-sm" placeholder="Search" style="width:100%">
                                        </div>
                                        <div class="col-4" style="text-align: right">
                                            <button name="action" value="search" type="submit"
                                                class="btn-sm btn-primary">Search
                                                <i class="fas fa-search"></i></button>
                                            <button name="action" value="reset" type="submit"
                                                class="btn-sm btn-secondary">Reset</button>
                                            <button name="action" value="generate-pdf" type="submit"
                                                class="btn-sm btn-outline-secondary">Export <i
                                                    class="fas fa-download"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <!-- The time line -->
                <div class="timeline">
                    <!-- timeline item -->
                    @foreach ($catalogs as $catalog)
                        <div>
                            <i class="fas fa-image bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i>
                                    {{ Carbon\Carbon::parse($catalog->updated_at)->diffForHumans() }}</span>
                                <div class="timeline-header">
                                    <h3>{{ $catalog->title }}</h3>
                                    <h6>{{ $catalog->school_year . ' ' . Str::ucfirst($catalog->semester->semester_name) }}
                                    </h6>

                                    @if (Auth::user()->type == 'Admin' || Auth::user()->type == 'Cashier')
                                        <div class="row float-right mt-n4 mr-2">
                                            <div class="mr-2">
                                                <a title="Edit Record" type="button"
                                                    href="{{ route('photo-catalog.edit', $catalog->id) }}"
                                                    class="btn btn-block btn-outline-warning btn-sm"
                                                    style="max-width: 35px">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('photo-catalog.destroy', $catalog->id) }}"
                                                method="post" id="formDeleteCatalog{{ $catalog->id }}">
                                                <button title="Delete Record" type="button"
                                                    class="btn btn-block btn-outline-danger btn-sm" style="width: 35px"
                                                    onclick="confirmSubmit('delete', 'formDeleteCatalog',
                                                '{{ $catalog->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div class="timeline-body">
                                    {!! $catalog->description !!}
                                </div>


                                <!-- Carousel Modal -->
                                <div class="modal fade" id="modal-default-{{ $catalog->id }}" data-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true"
                                    style="height:100%">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#212121">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span style="color: white" aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="height:80vh; background-color:#616161">
                                                <div id="carouselExampleIndicators-{{ $catalog->id }}"
                                                    class="carousel slide" data-ride="carousel"
                                                    style="height: 100%; display: flex !important">
                                                    <ol class="carousel-indicators">
                                                        @foreach ($catalog->images as $key => $val)
                                                            <li data-target="#carouselExampleIndicators-{{ $catalog->id }}"
                                                                data-slide-to="{{ $key }}"></li>
                                                        @endforeach
                                                    </ol>

                                                    <div class="carousel-inner" style="margin: auto !important;">
                                                        @foreach ($catalog->images as $key => $val)
                                                            <div class="carousel-item @if ($key == 0) active @endif"
                                                                style="height: 70vh">
                                                                <img class="d-block center-image"
                                                                    style="max-width: 100%; width: auto; height: 100%"
                                                                    src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $catalog->images[$key]->image_name) }}">
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <a class="carousel-control-prev"
                                                        href="#carouselExampleIndicators-{{ $catalog->id }}"
                                                        role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <div>
                                                        <a class="carousel-control-next"
                                                            href="#carouselExampleIndicators-{{ $catalog->id }}"
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
                                <div data-toggle="modal" data-target="#modal-default-{{ $catalog->id }}"
                                    style="cursor: pointer;">
                                    @if ($catalog->images)
                                        @if (count($catalog->images) == 2)
                                            <div class="pb-4" style="text-align:center; margin: 5px">
                                                <div class="row">
                                                    @foreach ($catalog->images as $image)
                                                        <div style="width:50%; float:left; padding: 5px">
                                                            <img class="img-fluid" style="width:100%"
                                                                src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $image->image_name) }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif (count($catalog->images) >= 3)
                                            <div class="pb-4" style="text-align:center; margin: 5px">
                                                <div class="row">
                                                    <div style="width:60%; float:left; padding: 5px;display: flex;">
                                                        <img class="img-fluid" style="width:100%;margin: auto;"
                                                            src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $catalog->images[0]->image_name) }}">
                                                    </div>

                                                    <div style="width:40%; float:left; padding: 5px">
                                                        <div style="width:100%; float:top; padding: 5px">
                                                            <img class="img-fluid" style="width:100%"
                                                                src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $catalog->images[1]->image_name) }}">
                                                        </div>
                                                        <div
                                                            style="width:100%; float:top; padding: 5px;position: relative;;">
                                                            <img class="img-fluid"
                                                                style="width:100%;@if (count($catalog->images) > 3) filter: brightness(50%) @endif"
                                                                src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $catalog->images[2]->image_name) }}">

                                                            @if (count($catalog->images) > 3)
                                                                <div class="text-block">
                                                                    <h1>+{{ count($catalog->images) - 3 }}</h1>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($catalog->images as $image)
                                                <div class="pb-4" style="text-align:center; padding: 5px">
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $image->image_name) }}">
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
                    <span class=" float-right">{{ $catalogs->links() }}</span>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->
    @endsection
