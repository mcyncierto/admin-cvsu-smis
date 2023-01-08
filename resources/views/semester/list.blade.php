@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title text-bold text-gray">Semesters List</span>

                    <div class="float-right mb-3">
                        <button type="button" class="btn btn-block btn-success mb-n3" data-toggle="modal" data-target="#create-form-modal">
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
                                <th>Semester Name</th>
                                <th style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semesters as $sem)
                                <tr>
                                    <td>{{ $sem->semester_name }}</td>
                                    <td class="display: flex;align-items: center; align-content: center;">
                                        <div style="width: 80px; text-align: center; margin: 0 auto;">
                                            <button title="Edit Record" type="button"
                                                class="btn btn-block btn-outline-info btn-sm float-left" style="max-width: 35px; height: 35px"
                                                data-toggle="modal" data-target="#edit-modal-{{ $sem->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('semesters.destroy', $sem->id) }}" method="post"
                                                id="formDelete{{ $sem->id }}">
                                                <button title="Delete Record" type="button" class="btn btn-block btn-outline-danger btn-sm float-right" style="width: 35px; height: 35px"
                                                    onclick="confirmSubmit('delete', 'formDelete',
                                                    '{{ $sem->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                    </td>
                                    @include('semester.edit_modal')
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $semesters->links() }}</span>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <form class="form-signin needs-validation" method="POST" action="{{ route('semesters.store') }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal fade" id="create-form-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Semester - Create New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group row" id="scholarship-type-name-div">
                                    <label for="semester_name" class="col-md-4 col-form-label text-md-right">{{ __('Semester Name') }}
                                        <span style="color:red">*</span></label>
                                    <div class="col-md-6">
                                        <input id="semester_name" type="text" class="form-control @error('semester_name') is-invalid @enderror"
                                            name="semester_name" required value="{{ old('semester_name') }}">
                                        @error('semester_name')
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
        @if (count($errors) > 0)
            $('#create-form-modal').modal('show');
        @endif
    }
</script>

<script type="text/javascript">
    window.onload = function() {
        @if ($errors->has('semester_name') && !$errors->has('semester_name_edit*'))
            $('#create-form-modal').modal('show');
        @elseif ($errors->has('semester_name_edit*'))
            $('#{{ session('modal_name') }}').modal('show');
        @endif
    }

    function clearCreateForm() {
        document.getElementById('semester_name').value = '';
        document.getElementById("semester_name").classList.remove("is-invalid");
    }
</script>