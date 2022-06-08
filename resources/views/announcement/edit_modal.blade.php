<form method="POST" action="{{ route('announcements.update', $announcement->id) }}" enctype="multipart/form-data" id="formUpdate{{ $announcement->id }}">
    @csrf
    @method('patch')
    <div class="modal fade" id="edit-announcement-modal-{{ $announcement->id  }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Announcement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                class="col-md-4 col-form-label text-md-right">{{ __('Content') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <textarea id="content{{ $announcement->id }}" class="form-control" rows="3" placeholder="Enter ..."
                                    @error('content{{ $announcement->id }}') is-invalid @enderror name="content" required>{{ $announcement->content }}</textarea>
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
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
