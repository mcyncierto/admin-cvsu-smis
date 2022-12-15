@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title text-bold text-gray">Application Process</span>
                        <div class="float-right mb-3">
                            <button type="button" class="btn btn-block btn-success mb-n3" data-toggle="modal" data-target="#application-form-modal">
                                <i class="fas fa-plus-circle"></i>
                                Create New
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="font-size: 16px">
                        <div class="card-body">
                            <p>1. Have a copy of the needed requirements. (See table below for reference)</p>
                            <p>2. Grade Point Average (GPA) should meet the required range. (See table below for reference)</p>
                            <p>3. Within the Application Form below, select the desired Scholarship type and upload your requirements.</p>
                            <p>4. Once done uploading, click the Submit for Approval and wait for the result.</p>
                            <p>5. The scholarship coordinator will double check your submitted requirements before approving it.</p>
                            <p>6. Go to List and check your scholarship application status.</p>
                            
                            <table class="table table-bordered table-hover" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>Scholarship Type</th>
                                        <th>GPA Range</th>
                                        <th>Shouldn't have</th>
                                        <th>Requirements</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requirements as $requirement)
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td>{{ $requirement->scholarship_type_name }}</td>
                                        <td>
                                            @if (!empty($requirement->lowest_gpa_allowed) && !empty($requirement->highest_gpa_allowed))
                                                {{ $requirement->highest_gpa_allowed." - ".$requirement->lowest_gpa_allowed}}
                                            @else
                                                n/a
                                            @endif
                                        </td>
                                        <td>{{ !empty($requirement->restrictions) ? $requirement->restrictions : "n/a" }}</td>
                                        <td>{{ $requirement->requirements }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <form class="form-signin needs-validation" method="POST" action="{{ route('scholarships.store') }}"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal fade" id="application-form-modal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Scholarship Application - Create New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="semester"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Semester') }}</label>
    
                                    <div class="col-md-6">
                                        <select id="semester" class="form-control" @error('semester') is-invalid @enderror
                                            name="semester" required>
                                            @foreach ($semester as $sem)
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
                                    <label for="school_year"
                                        class="col-md-4 col-form-label text-md-right">{{ __('School Year') }} <span
                                            style="color:red">*</span></label>
    
                                    <div class="col-md-6">
                                        <select id="school_year" class="form-control"
                                            @error('school_year') is-invalid @enderror name="school_year" required>
                                            @foreach ($school_year as $year)
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
                                    <label for="scholarship_type"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Scholarship Type') }} <span
                                            style="color:red">*</span></label>
    
                                    <div class="col-md-6">
                                        <select id="scholarship_type" class="form-control"
                                            @error('scholarship_type') is-invalid @enderror name="scholarship_type" required
                                            onchange="getRequirements(this.value)">
                                            <option value="" disabled selected>Select here</option>
                                            @foreach ($scholarship_type as $type)
                                                <option value={{ $type['id'] }}>{{ $type['scholarship_type_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('scholarship_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group row" id="org-div">
                                    <label for="org" class="col-md-4 col-form-label text-md-right">{{ __('Organization') }}
                                        <span id="req-org" style="color:red; display: none">*</span></label>
                                    <div class="col-md-6">
                                        <input id="org" type="text" class="form-control @error('org') is-invalid @enderror"
                                            name="org">
                                        @error('org')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group row mb-1">
                                    <label for="files"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Upload Requirements:') }} <span
                                            style="color:red">*</span>
                                    </label>
                                    <div class='form-group row' id="attachment-div"></div>
                                </div>
                                <div id="requirements-list-div" class='form-group row'></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="submitBtnScholarship" name="action" type="submit" value="save_for_later"
                                class="btn btn-primary float-right">Save for Later</button>
                            <button id="submitBtnScholarship" name="action" type="submit" value="for_approval"
                                class="btn btn-warning float-right">Submit for Approval</button>
                            <button data-dismiss="modal" id="cancel" name="btn-cancel" type="button" value="disapprove" 
                                class="btn btn-outline-secondary float-right">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </form>


    </div>
@endsection()
<script>
    function getRequirements(id) {
        var baseURL = window.location.origin + '/cvsu-smis';
        // AJAX request 
        $.ajax({
            url: baseURL + '/requirement-types/',
            data: {
                scholarship_type_id: id
            },
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var reqs = [];
                $('#requirements-list-div').empty();
                $('#attachment-div').empty();
                $('#req-org').hide();
                $('#org').prop('required', false);

                if (response['data'].length > 0) {
                    for (var i = 0; i < response['data'].length; i++) {
                        if (response['data'][i].input_type == "attachment") {
                            reqs.push(response['data'][i].requirement_name);
                        } else if (response['data'][i].requirement_name == "Organization" && response[
                                'data'][i].input_type == "textbox") {
                            $('#req-org').show();
                            $('#org').prop('required', true);
                        }
                    }
                    $('#requirements-list-div').append(
                        "<span class='font-italic text-muted col-md-4 text-md-right'>Requirements needed:</span>" +
                        "<span class='font-italic text-info col-md-6'>" + reqs.join(', ') + "</span>"
                    );
                    $('#attachment-div').append(
                        "<div class='col-md-6'>" +
                        "<input id='attachment' type='file' name='attachment[]' multiple required accept='.pdf,.doc,.docx'>" +
                        "<i class='text-muted'>(accepts .pdf, .doc, .docx)</i><br>" +
                        "</div>"
                    );
                } else {
                    $('#attachment-div').append(
                        "<div class='col-md-12 mt-2'>" +
                        "<span class='text-md-right font-italic text-muted'>No other requirements needed.</span>" +
                        "</div>"
                    );
                }
            }
        });
    }
</script>
