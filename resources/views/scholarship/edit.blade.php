@extends('layouts.main')

@section('content')
    <form class="form-signin needs-validation" method="POST" action="{{ route('scholarships.update', $scholarship->id) }}"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('patch')
        <!-- Input addon -->
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Scholarship Application - Edit</h3>
                        </div>
                        <div class="card-body">
                            @if ($scholarship->is_qualified)
                            <div class="alert alert-success mb-4">
                                {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> --}}
                                <h5><i class="icon fas fa-check"></i> Qualified</h5>
                                This applicant is qualified to the Scholarship Type. Please check the attached requirements.
                            </div>
                            @endif

                            <div class="form-group row">
                                <label for="semester"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Semester') }}</label>

                                <div class="col-md-6">
                                    <select id="semester" class="form-control" @error('semester') is-invalid @enderror
                                        name="semester" required>
                                        <option selected value={{ $current_semester['id'] }}>{{ $current_semester['semester_name'] }}</option>
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
                                            <option @if ($scholarship->school_year == $year) selected @endif)>{{ $year }}</option>
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
                                    class="col-md-4 col-form-label text-md-right">{{ __('Scholarship Type') }} <span style="color:red">*</span></label>

                                <div class="col-md-6">
                                    <select id="scholarship_type" class="form-control" @error('scholarship_type') is-invalid @enderror
                                        name="scholarship_type" required onchange="getRequirements(this.value)">
                                        <option value="" disabled selected>Select here</option>
                                        @foreach ($scholarship_type as $type)
                                            <option 
                                                value={{ $type['id'] }}
                                                @if ($scholarship->scholarship_type_id == $type['id']) selected @endif)
                                            >
                                                {{ $type['scholarship_type_name'] }}
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

                            <div class="form-group row">
                                <label for="gpa"
                                    class="col-md-4 col-form-label text-md-right">{{ __('GPA') }}</label>

                                <div class="col-md-6">
                                    <input id="gpa" type="text"
                                        class="form-control @error('gpa') is-invalid @enderror"
                                        value="{{ $scholarship->gpa }}"
                                        name="gpa" readonly>
                                    @error('gpa')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row" id="org-div" style="display: @if (empty($scholarship->organization)) none @endif">
                                <label for="org"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Organization') }} <span style="color:red">*</span></label>
                                <div class="col-md-6">
                                    <input id="org" type="text"
                                        class="form-control @error('org') is-invalid @enderror"
                                        value="{{ $scholarship->organization }}"
                                        name="org">
                                    @error('org')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            @if (Auth::user()->type == 'Admin')
                            <div class="form-group row">
                                <label for="remarks"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>
                                <div class="col-md-6">
                                    <textarea id="remarks" class="form-control" rows="3" name="remarks">{{ $scholarship->remarks }}</textarea>
                                    @error('remarks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            <div class="form-group row mb-1">
                                <label for="files"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Upload Requirements:') }}<br>
                                </label>
                                <div class='form-group row' id="attachment-div"></div>
                            </div>

                            <div class="form-group row">
                                <span class='font-italic text-muted col-md-4 text-md-right'>Uploaded File(s):</span>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        @foreach ($requirements as $requirement)
                                            <tr>
                                                <td>{{ $requirement['attachment'] }}</th>
                                                <td>
                                                    <a type="button" class="btn btn-outline-dark btn-sm"
                                                        href="{{ route('scholarships.view-attachment', ['id' => $requirement['scholarship_id'], 'file_name' => $requirement['attachment']]) }}"
                                                        target="_blank">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                                
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                            <div id="requirements-list-div" class='form-group row'></div>
                        </div>
                        <div class="modal-footer">
                            @if ($scholarship->status == 0)
                                <button id="submitBtnScholarship" name="action" type="submit" value="save_for_later" class="btn btn-primary float-right">Save for Later</button>
                            @endif

                            @if ($scholarship->status == 0)
                                <button id="submitBtnScholarship" name="action" type="submit" value="for_approval" class="btn btn-warning float-right">Submit for Approval</button>
                            @endif

                            @if ($scholarship->status == 1 && Auth::user()->type == 'Admin')
                                <button id="submitBtnScholarship" name="action" type="submit" value="approve" class="btn btn-success float-right">Approve</button>
                            @endif

                            @if (($scholarship->status == 1 || $scholarship->status == 2) && Auth::user()->type == 'Admin')
                                <button id="submitBtnScholarship" name="action" type="submit" value="disapprove" class="btn btn-danger float-right">Disapprove</button>
                            @endif

                            <a href="{{ route('scholarships.index') }}" id="cancel" name="btn-cancel" type="button" value="disapprove" class="btn btn-outline-secondary float-right">Cancel</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </form>
@endsection()
<script>
    window.onload = function() {
        getRequirements($('#scholarship_type').val());
    }; 
    function getRequirements(id) {
        var baseURL = window.location.origin + '/cvsu-smis';
        // AJAX request 
        $.ajax({
            url: baseURL + '/requirement-types/',
            data: {scholarship_type_id: id},
            type: 'get',
            dataType: 'json',
            success: function(response){
                var reqs = [];
                // console.log(response['data']);
                $('#requirements-list-div').empty();
                $('#attachment-div').empty();
                $('#org-div').hide();
                $('#org').prop('required', false);

                if (response['data'].length > 0){
                    for (var i = 0; i < response['data'].length; i++){
                        if (response['data'][i].input_type == "attachment") {
                            reqs.push(response['data'][i].requirement_name);
                        } else if (response['data'][i].requirement_name == "Organization" && response['data'][i].input_type == "textbox") {
                            $('#org-div').show();
                            $('#org').prop('required', true);
                        }
                    }
                    $('#requirements-list-div').append(
                        "<span class='font-italic text-muted col-md-4 text-md-right'>Requirements needed:</span>" +
                        "<span class='font-italic text-info col-md-6'>"+ reqs.join(', ') +"</span>"
                    );
                    $('#attachment-div').append(
                        "<div class='col-md-15'>" +
                            "<input class='ml-3' id='attachment' type='file' name='attachment[]' multiple accept='.pdf,.doc,.docx'><br>" +
                            "<i class='ml-3 text-muted'>(accepts .pdf, .doc, .docx)</i><br>" +
                            "<i class='ml-3 text-danger'>If not changing files to be uploaded, please leave it blank.</i>" +
                        "</div>"
                    );
                } else {
                    $('#attachment-div').append(
                        "<div class='col-md-12 mt-2'>" +
                            "<span class='text-md-right font-italic text-muted'>No other requirements needed.</span>" +
                        "</div>"
                    );
                }
                
                // if (response['data'].length > 0){
                //     for (var i = 0; i < response['data'].length; i++){
                //         if (response['data'][i].input_type == "attachment") {
                //             inputType = "<input id='attachment' type='file' name='attachment[]' multiple>";
                //             $('#requirements-div').append(
                //                 "<div class='form-group row'>" +
                //                     "<span class='col-md-4 col-form-label text-md-right font-italic text-info'>"+response['data'][i].requirement_name+"</span>" +
                //                     "<div class='col-md-6'>" +
                //                             inputType +
                //                     "</div>" +
                //                 "</div>"
                //             );
                //         } else if (response['data'][i].requirement_name == "Organization" && response['data'][i].input_type == "textbox") {
                //             $('#org-div').show();
                //             $('#org').prop('required', true);
                //         }
                //     }
                // } else {
                //     $('#requirements-div').append(
                //         "<div class='form-group row'>" +
                //             "<span class='col-md-6 col-form-label text-md-right font-italic text-muted'>No other requirements needed.</span>" +
                //         "</div>"
                //     );
                // }
            }
        });
    }
</script>
