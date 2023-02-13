<form class="form-signin needs-validation" method="POST" action="{{ route('photo-catalog.store') }}"
    enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="add-photo-catalog-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Photo Catalog</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" required autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" style="width: 500px" class="form-control" placeholder="Enter here ..."
                                    @error('description') is-invalid @enderror name="description"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="school_year"
                                class="col-md-4 col-form-label text-md-right">{{ __('School Year') }} <span
                                    style="color:red">*</span></label>

                            <div class="col-md-6">
                                <select id="school_year" class="form-control"
                                    @error('school_year') is-invalid @enderror name="school_year" required>
                                    @foreach ($school_years as $year)
                                        <option>{{ $year }}</option>
                                    @endforeach
                                </select>
                                @error('school_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester"
                                class="col-md-4 col-form-label text-md-right">{{ __('Semester') }} <span
                                style="color:red">*</span></label>

                            <div class="col-md-6">
                                <select id="semester" class="form-control" @error('semester') is-invalid @enderror
                                    name="semester" required>
                                    @foreach ($semesters as $sem)
                                        <option selected value={{ $sem['id'] }}>
                                            {{ $sem['semester_name'] }}</option>
                                    @endforeach
                                </select>
                                @error('semester')
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
                                <input id="photo" type="file" name="photo[]" multiple accept='image/*'>
                            </div>
                            <div class="col-md-12">
                                <div class="mt-1 text-center">
                                    <div class="images-preview-div"> </div>
                                </div>  
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
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );
</script>