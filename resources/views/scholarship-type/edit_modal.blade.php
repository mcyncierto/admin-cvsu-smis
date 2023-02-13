<form method="POST" action="{{ route('scholarship-types.update', $scholarshipType->id) }}" enctype="multipart/form-data" id="formUpdate{{ $scholarshipType->id }}">
    @csrf
    @method('patch')
    <div class="modal fade" id="edit-modal-{{ $scholarshipType->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Scholarship Type</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="scholarship_type_name" class="col-md-4 col-form-label text-md-right">{{ __('Scholarship Type Name') }} <span style="color:red">*</span></label>

                            <div class="input-group col-md-6">
                                <input id="scholarship_type_name_edit{{ $scholarshipType->id }}" type="text"
                                    class="form-control @error('scholarship_type_name_edit'.$scholarshipType->id) is-invalid @enderror" name="scholarship_type_name"
                                    value="{{ $scholarshipType->scholarship_type_name }}" required autocomplete="scholarship_type_name" autofocus>

                                @error('scholarship_type_name_edit'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="input-group col-md-6">
                                <input id="description{{ $scholarshipType->id }}" type="text"
                                    class="form-control @error('description'.$scholarshipType->id) is-invalid @enderror" name="description"
                                    value="{{ $scholarshipType->description }}" autocomplete="description">

                                @error('description'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lowest_gpa_allowed" class="col-md-4 col-form-label text-md-right">{{ __('Lowest GPA Allowed') }}</label>

                            <div class="input-group col-md-2">
                                <input id="lowest_gpa_allowed{{ $scholarshipType->id }}" type="number"
                                    class="form-control @error('lowest_gpa_allowed'.$scholarshipType->id) is-invalid @enderror" name="lowest_gpa_allowed"
                                    value="{{ $scholarshipType->lowest_gpa_allowed }}" autocomplete="lowest_gpa_allowed">

                                @error('lowest_gpa_allowed'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="highest_gpa_allowed" class="col-md-4 col-form-label text-md-right">{{ __('Highest GPA Allowed') }}</label>

                            <div class="input-group col-md-2">
                                <input id="highest_gpa_allowed{{ $scholarshipType->id }}" type="number"
                                    class="form-control @error('highest_gpa_allowed'.$scholarshipType->id) is-invalid @enderror" name="highest_gpa_allowed"
                                    value="{{ $scholarshipType->highest_gpa_allowed }}" autocomplete="highest_gpa_allowed">

                                @error('highest_gpa_allowed'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="restrictions" class="col-md-4 col-form-label text-md-right">{{ __('Restrictions') }}</label>

                            <div class="input-group col-md-6">
                                <input id="restrictions{{ $scholarshipType->id }}" type="text"
                                    class="form-control @error('restrictions'.$scholarshipType->id) is-invalid @enderror" name="restrictions"
                                    value="{{ $scholarshipType->restrictions }}" autocomplete="restrictions">
                                    
                                @error('restrictions'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="restrictions" class="col-md-4 col-form-label text-md-right"></label>
                            <i>
                                <span class='text-danger'>Note:</span>
                                <span class='text-muted'> Use comma to separate multiple values.</span><br>
                                <span class='text-muted'>e.g. INC,Dropped</span>
                            </i>
                        </div>

                        <div class="form-group row">
                            <label for="requirements" class="col-md-4 col-form-label text-md-right">{{ __('Requirements') }}</label>

                            <div class="input-group col-md-6">
                                <input id="requirements{{ $scholarshipType->id }}" type="text"
                                    class="form-control @error('requirements'.$scholarshipType->id) is-invalid @enderror" name="requirements"
                                    value="{{ $scholarshipType->requirements }}" autocomplete="requirements">

                                @error('requirements'.$scholarshipType->id)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="restrictions" class="col-md-4 col-form-label text-md-right"></label>
                            <i>
                                <span class='text-danger'>Note:</span>
                                <span class='text-muted'> Use comma to separate multiple values.</span><br>
                                <span class='text-muted'>e.g. Certificate of Grades,Certificate of Registration</span>
                            </i>
                        </div>


                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="submitBtn{{ $scholarshipType->id }}" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
