@extends('layouts.main')

@section('content')
<form method="POST" action="{{ route('announcements.update', $announcement->id) }}" enctype="multipart/form-data" id="formUpdate{{ $announcement->id }}">
    @csrf
    @method('patch')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit Announcement</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="title{{ $announcement->id }}" type="text" class="form-control @error('title{{ $announcement->id }}') is-invalid @enderror"
                                    name="title" required autofocus value="{{ $announcement->title }}">
                                @error('title{{ $announcement->id }}')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="content"
                                class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>

                            <div class="col-md-6">
                                <textarea id="content" class="form-control textarea-content" rows="3" placeholder="Enter ..."
                                    @error('content{{ $announcement->id }}') is-invalid @enderror name="content">{!! $announcement->content !!}</textarea>
                                @error('content{{ $announcement->id }}')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="content"
                                class="col-md-4 col-form-label text-md-right">{{ __('Type') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <select id="type" class="form-control" @error('type') is-invalid @enderror name="type" required>
                                    <option {{ ($announcement->type == 'General' ? 'selected' : '')}}>General</option>
                                    <option {{ ($announcement->type == 'Event' ? 'selected' : '')}}>Event</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" name="photo">
                                </br><i class="text-info">If not changing profile picture, please leave it
                                    blank.</i>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="{{ route('announcements.index') }}" id="cancel" name="btn-cancel" type="button" value="disapprove" class="btn btn-outline-secondary float-right">Cancel</a>
                        <button id="submitBtn" type="submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</form>
<script>
    ClassicEditor
        .create( document.querySelector( "#content" ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection()
