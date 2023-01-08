@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title text-bold text-gray">Scholarship Types List</span>

                    <div class="float-right mb-3">
                        <button type="button" onclick="clearCreateForm()" class="btn btn-block btn-success mb-n3" data-toggle="modal" data-target="#create-form-modal">
                            <i class="fas fa-plus-circle"></i>
                            Create New
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Lowest GPA Allowed</th>
                                <th>Highest GPA Allowed</th>
                                <th>Restrictions</th>
                                <th>Requirements</th>
                                <th style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scholarshipTypes as $scholarshipType)
                                <tr>
                                    <td>{{ $scholarshipType->scholarship_type_name }}</td>
                                    <td>{{ $scholarshipType->description}}</td>
                                    <td>{{ $scholarshipType->lowest_gpa_allowed}}</td>
                                    <td>{{ $scholarshipType->highest_gpa_allowed}}</td>
                                    <td>{{ $scholarshipType->restrictions}}</td>
                                    <td>{{ $scholarshipType->requirements}}</td>
                                    <td>
                                        <div style="width: 80px">
                                            <button title="Edit Record" type="button"
                                                class="btn btn-block btn-outline-info btn-sm float-left" style="max-width: 35px; height: 35px"
                                                data-toggle="modal" data-target="#edit-modal-{{ $scholarshipType->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('scholarship-types.destroy', $scholarshipType->id) }}" method="post"
                                                id="formDelete{{ $scholarshipType->id }}">
                                                <button title="Delete Record" type="button" class="btn btn-block btn-outline-danger btn-sm float-right" style="width: 35px; height: 35px"
                                                    onclick="confirmSubmit('delete', 'formDelete',
                                                    '{{ $scholarshipType->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                    </td>
                                    @include('scholarship-type.edit_modal')
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $scholarshipTypes->links() }}</span>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <form class="form-signin needs-validation" method="POST" action="{{ route('scholarship-types.store') }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal fade" id="create-form-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Scholarship Type - Create New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group row" id="scholarship-type-name-div">
                                    <label for="scholarship_type_name" class="col-md-4 col-form-label text-md-right">{{ __('Scholarship Type Name') }}
                                        <span style="color:red">*</span></label>
                                    <div class="col-md-6">
                                        <input id="scholarship_type_name" type="text" class="form-control @error('scholarship_type_name') is-invalid @enderror"
                                            name="scholarship_type_name" required value="{{ old('scholarship_type_name') }}">
                                        @error('scholarship_type_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="description-div">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                    <div class="col-md-6">
                                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                            name="description" value="{{ old('description') }}">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="lowest-gpa-allowed-div">
                                    <label for="lowest_gpa_allowed" class="col-md-4 col-form-label text-md-right">{{ __('Lowest GPA Allowed') }}</label>
                                    <div class="col-md-2">
                                        <input id="lowest_gpa_allowed" type="number" class="form-control @error('lowest_gpa_allowed') is-invalid @enderror"
                                            name="lowest_gpa_allowed" value="{{ old('lowest_gpa_allowed') }}">
                                        @error('lowest_gpa_allowed')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="highest-gpa-allowed-div">
                                    <label for="highest_gpa_allowed" class="col-md-4 col-form-label text-md-right">{{ __('Highest GPA Allowed') }}</label>
                                    <div class="col-md-2">
                                        <input id="highest_gpa_allowed" type="text" class="form-control @error('highest_gpa_allowed') is-invalid @enderror"
                                            name="highest_gpa_allowed" value="{{ old('highest_gpa_allowed') }}">
                                        @error('highest_gpa_allowed')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="restrictions-div">
                                    <label for="restrictions" class="col-md-4 col-form-label text-md-right">{{ __('Restrictions') }}</label>
                                    <div class="col-md-6">
                                        <input id="restrictions" type="text" class="form-control @error('restrictions') is-invalid @enderror"
                                            name="restrictions" value="{{ old('restrictions') }}">
                                        <i>
                                            <span class='text-danger'>Note:</span>
                                            <span class='text-muted'> Use comma to separate multiple values.</span><br>
                                            <span class='text-muted'>e.g. INC,Dropped</span>
                                        </i>
                                        @error('restrictions')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="requirements-div">
                                    <label for="requirements" class="col-md-4 col-form-label text-md-right">{{ __('Requirements') }}</label>
                                    <div class="col-md-6">
                                        <input id="requirements" type="text" class="form-control @error('requirements') is-invalid @enderror"
                                            name="requirements" value="{{ old('requirements') }}">
                                        <i>
                                            <span class='text-danger'>Note:</span>
                                            <span class='text-muted'> Use comma to separate multiple values.</span><br>
                                            <span class='text-muted'>e.g. Certificate of Grades,Certificate of Registration</span>
                                        </i>
                                        @error('requirements')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div id="requirements-list-div" class='form-group row'></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="submitBtn" name="action" type="submit" value="save"
                                class="btn btn-primary float-right">Save</button>
                            <button data-dismiss="modal" id="cancel" name="btn-cancel" type="button"
                                class="btn btn-outline-secondary float-right">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </form>
    </div>
@endsection
<script type="text/javascript">
    window.onload = function() {
        @if ($errors->has('scholarship_type_name') && !$errors->has('scholarship_type_name_edit*'))
            $('#create-form-modal').modal('show');
        @elseif ($errors->has('scholarship_type_name_edit*'))
            $('#{{ session('modal_name') }}').modal('show');
        @endif
    }

    function clearCreateForm() {
        document.getElementById('scholarship_type_name').value = '';
        document.getElementById('description').value = '';
        document.getElementById('lowest_gpa_allowed').value = '';
        document.getElementById('highest_gpa_allowed').value = '';
        document.getElementById('restrictions').value = '';
        document.getElementById('requirements').value = '';
        document.getElementById("scholarship_type_name").classList.remove("is-invalid");
    }
</script>