@extends('layouts.main')

@section('content')
<form method="POST" action="{{ route('photo-catalog.update', $catalog->id) }}" enctype="multipart/form-data" id="formUpdate{{ $catalog->id }}">
    @csrf
    @method('patch')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit Photo Catalog</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <input id="title{{ $catalog->id }}" type="text" class="form-control @error('title{{ $catalog->id }}') is-invalid @enderror"
                                    name="title" required autofocus value="{{ $catalog->title }}">
                                @error('title{{ $catalog->id }}')
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
                                <textarea id="description" class="form-control textarea-description" rows="3" placeholder="Enter ..."
                                    @error('description{{ $catalog->id }}') is-invalid @enderror name="description">{!! $catalog->description !!}</textarea>
                                @error('description{{ $catalog->id }}')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="semester"
                                class="col-md-4 col-form-label text-md-right">{{ __('Semester') }}</label>

                            <div class="col-md-6">
                                <select id="semester" class="form-control" @error('semester') is-invalid @enderror
                                    name="semester" required>
                                    @foreach ($semester as $sem)
                                        <option @if ($catalog->semester_id == $sem['id']) selected @endif value={{ $sem['id'] }}>{{ $sem['semester_name'] }}</option>
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
                            <label for="school_year"
                                class="col-md-4 col-form-label text-md-right">{{ __('School Year') }} <span style="color:red">*</span></label>

                            <div class="col-md-6">
                                <select id="school_year" class="form-control" @error('school_year') is-invalid @enderror
                                    name="school_year" required>
                                    @foreach ($school_year as $year)
                                        <option @if ($catalog->school_year == $year) selected @endif>{{ $year }}</option>
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
                            <label for="photo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input id="photo" type="file" name="photo[]" multiple accept='image/*'>
                                </br><i class="text-info">If not changing images, please leave it
                                    blank.</i>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="{{ route('photo-catalog.index') }}" id="cancel" name="btn-cancel" type="button" value="disapprove" class="btn btn-outline-secondary float-right">Cancel</a>
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
        .create( document.querySelector( "#description" ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection()
