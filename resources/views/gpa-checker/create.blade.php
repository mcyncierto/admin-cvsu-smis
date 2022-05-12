@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">GPA Checker</h3>
            </div>
            <i class="ml-4 mt-2">
                <span class="text-muted">Upload Student Master List here with GPA and Enrollment status to be processed for </span>
                <span class="text-danger">Automatic Checking of Qualified Applicants.</span>
            </i>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('gpa-checker.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="semester"
                            class="col-md-4 col-form-label">{{ __('Semester') }} <span style="color:red">*</span></label>

                        <div class="col-md-4">
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

                    <div class="form-group">
                        <label for="school_year"
                            class="col-md-4 col-form-label">{{ __('School Year') }} <span style="color:red">*</span></label>

                        <div class="col-md-4">
                            <select id="school_year" class="form-control" @error('school_year') is-invalid @enderror
                                name="school_year" required>
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

                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="file">File Upload<span style="color:red">*</span></label>
                            <div class="input-group mb-2">
                                <div class='col-md-8'>
                                    <div class="custom-file">
                                        <input class="custom-file-input" id='file' type='file' name='file' required accept='.xlsx, .xls'>
                                        <label class="custom-file-label" for="file">Choose file</label>
                                    </div>
                                    <div class="mt-2">
                                        <i class='text-muted'>(accepts .xlsx, .xls)</i>
                                        <a class='mb-n2 text-success float-right' href='{{ asset('storage/student-records-template.xlsx') }}' download>
                                            <i class="fas fa-download"></i>
                                            Download Student Record Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button name="action" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Records</h3>

                <form action="{{ route('gpa-checker.create') }}" method="post" id="formSearch" class="card-tools">
                    @method('get')
                    @csrf
                    <div class="card-tools">
                        <div class="row">
                            <div class="col-2">
                                <select id="filter_school_year" name="filter_school_year" class="form-control-sm" style="width:100%">
                                    <option value="" selected>Filter School Year here</option>
                                    @foreach ($school_years as $school_year)
                                        <option @if ($filter_school_year == $school_year) selected @endif) value="{{ $school_year }}">{{ $school_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <select id="filter_semester" name="filter_semester" class="form-control-sm" style="width:100%">
                                    <option value="" selected>Filter Semester here</option>
                                    @foreach ($semesters as $semester)
                                        <option @if ($filter_semester == $semester['semester_name']) selected @endif) value="{{ $semester['semester_name'] }}">{{ $semester['semester_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <select id="filter_course" name="filter_course" class="form-control-sm" style="width:100%">
                                    <option value="" selected>Filter Course here</option>
                                    @foreach ($courses as $course)
                                        <option @if ($filter_course == $course['course_name']) selected @endif) value="{{ $course['course_name'] }}">{{ $course['course_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="text" value="{{ $search }}" name="search" class="form-control-sm" placeholder="Search" style="width:100%">
                            </div>
                            <div class="col-2">
                                <button name="action" value="search" type="submit" class="btn-sm btn-primary">Search <i class="fas fa-search"></i></button>
                                <button name="action" value="reset" type="submit" class="btn-sm btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed table-hover">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>GPA</th>
                            <th class="text-center">Has INC</th>
                            <th class="text-center">Has Dropped</th>
                            <th class="text-center">Enrolled?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td>{{ $record->student_number }}</td>
                                @if (!empty($record->first_name)) 
                                    <td>{{ implode(' ', [$record->first_name, $record->middle_name, $record->last_name]) }}</td>
                                @else 
                                    <td class="text-danger"><i>{{ 'No existing record in database' }}</i></td>
                                @endif
                                <td>{{ $record->email}}</td>
                                <td>{{ $record->course}}</td>
                                <td>{{ $record->school_year}}</td>
                                <td>{{ $record->semester_name}}</td>
                                <td>{{ $record->gpa}}</td>
                                <td class="text-center">
                                    @if ($record->has_inc)
                                        <span class="fas fa-check-circle text-danger" style="font-size:18px"></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($record->has_dropped)
                                        <span class="fas fa-check-circle text-danger" style="font-size:18px"></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($record->is_enrolled)
                                        <span class="fas fa-check-circle text-success" style="font-size:18px"></span>
                                    @endif
                                </td>
                                {{-- @include('user.edit_modal') --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <span class=" float-right">{{ $records->links() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection()