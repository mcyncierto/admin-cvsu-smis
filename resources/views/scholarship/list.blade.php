@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="card-title text-bold text-gray">Scholarships List</span>

                    <form action="{{ route('scholarships.index') }}" method="post" id="formSearchScholarship" class="card-tools">
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
                                <div class="col-2">
                                    <select id="filter_course" name="filter_course" class="form-control-sm" style="width:100%">
                                        <option value="" selected>Filter Course here</option>
                                        @foreach ($courses as $course)
                                            <option @if ($filter_course == $course['course_name']) selected @endif) value="{{ $course['course_name'] }}">{{ $course['course_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select id="filter_scholarship_type" name="filter_scholarship_type" class="form-control-sm" style="width:100%">
                                        <option value="" selected>Filter Scholarship Type here</option>
                                        @foreach ($scholarship_types as $scholarship_type)
                                            <option @if ($filter_scholarship_type == $scholarship_type['scholarship_type_name']) selected @endif) value="{{ $scholarship_type['scholarship_type_name'] }}">{{ $scholarship_type['scholarship_type_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <input type="text" value="{{ $search }}" name="search" class="form-control-sm" placeholder="Search" style="width:100%">
                                </div>
                                <div class="col-2">
                                    <button name="action" value="search" type="submit" class="btn-sm btn-primary">Search <i class="fas fa-search"></i></button>
                                    <button name="action" value="reset" type="submit" class="btn-sm btn-secondary">Reset</button>
                                    <button name="action" value="generate-pdf" type="submit" class="btn-sm btn-outline-secondary">Export <i class="fas fa-download"></i></button>
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
                                <th>School Year - Semester</th>
                                <th>Course</th>
                                <th>GPA</th>
                                <th>Organization</th>
                                <th>Scholarship Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Qualified?</th>
                                <th>Remarks</th>
                                <th style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($scholarships as $scholarship)
                                <tr>
                                    <td>{{ $scholarship->student_number }}</td>
                                    <td>{{ implode(' ', [$scholarship->first_name, $scholarship->middle_name, $scholarship->last_name])}}</td>
                                    <td>{{ $scholarship->email}}</td>
                                    <td>{{ $scholarship->school_year}}</br>{{ $scholarship->semester_name}}</td>
                                    <td>{{ $scholarship->course}}</td>
                                    <td>{{ $scholarship->gpa}}</td>
                                    <td>{{ $scholarship->organization}}</td>
                                    <td>{{ $scholarship->scholarship_type_name}}</td>
                                    <td class="text-center"> 
                                        <span style="font-size:12px" class="badge
                                        @if ($scholarship->status_name == 'For Approval') badge-warning
                                        @elseif ($scholarship->status_name == 'Approved') badge-success
                                        @elseif ($scholarship->status_name == 'Created') badge-secondary
                                        @endif
                                        ">
                                            {{ $scholarship->status_name}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($scholarship->is_qualified)
                                            <span class="fas fa-check-circle text-success" style="font-size:18px"></span>
                                        @endif
                                    </td>
                                    <td>{{ $scholarship->remarks}}</td>
                                    <td style="width:110px">
                                        <div>
                                            <a title="Edit User" type="button"
                                                href="{{ route('scholarships.edit', $scholarship->id) }}"
                                                class="btn btn-block btn-outline-info btn-sm float-left" style="max-width: 35px"
                                                @if (Auth::user()->type != 'Admin' && $scholarship->status_name != 'Created') disabled @endif>
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('scholarships.destroy', $scholarship->id) }}" method="post"
                                                id="formDeleteScholarship{{ $scholarship->id }}">
                                                <button title="Delete Record" type="button" class="btn btn-block btn-outline-danger btn-sm 
                                                        float-right" style="width: 35px"
                                                    onclick="confirmSubmit('delete', 'formDeleteScholarship',
                                                    '{{ $scholarship->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                    </td>
                                    {{-- @include('user.edit_modal') --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $scholarships->links() }}</span>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
