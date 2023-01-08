<form method="POST" action="{{ route('semesters.update', $sem->id) }}" enctype="multipart/form-data" id="formUpdate{{ $sem->id }}">
    @csrf
    @method('patch')
    <div class="modal fade" id="edit-modal-{{ $sem->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Semester</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="semester_name" class="col-md-4 col-form-label text-md-right">{{ __('Semester Name') }} <span style="color:red">*</span></label>

                            <div class="input-group col-md-6">
                                <input id="semester_name_edit{{ $sem->id }}" type="text"
                                    class="form-control @error('semester_name_edit'.$sem->id) is-invalid @enderror" name="semester_name"
                                    value="{{ $sem->semester_name }}" required autocomplete="semester_name" autofocus>

                                @error('semester_name_edit'.$sem->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="submitBtn{{ $sem->id }}" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
