<!DOCTYPE html>
<html>
<head>
    <title>Scholarship Application List</title>
    <style>
        table.tb {
          border: 1px solid black;
          font-size: 11px;
          margin-top: 20px;
        }

        .tb th, .tb td {
          border: 1px solid black;
          font-size: 11px
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        img {
            width: 100px,
            height: auto,
            position:absolute;
        }

        p {
            margin-top: -7px;
        }

        .container {
            width: 100%;
            position: relative;
        }

        .content {
            width: 400px;
            padding: 20px;
            overflow: hidden;
            margin:0 auto;
            position: relative;
            text-align: center;
        }

        .content img {
            margin-right: 15px;
            float: left;
        }

        .content h3,
        .content p{
            margin-left: 15px;
            display: block;
            margin: 2px 0 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <img src="{{ asset('images/cvsu-logo.png') }}" alt="CvSU Logo">
            <p>Republic of the Philippines</p>
            <p><strong>CAVITE STATE UNIVERSITY<strong></p>
            <p><strong>Bacoor Campus<strong></p>
            <p>SHIV, Molino VI, City of Bacoor</p>
            <p>(046) 476-5029</p>
        </div>
    </div>
    <hr>
    <h3>Scholarship Application List Report</h3>
    <table style="font-size: 13px">
        <tr>
            <td><b>School Year:</b> {{$filters['filter_school_year']}}</td>
            <td><b>Course:</b> {{$filters['filter_course']}}</td>
        </tr>
        <tr>
            <td><b>Semester:</b> {{$filters['filter_semester']}}</td>
            <td><b>Scholarship Type:</b> {{$filters['filter_scholarship_type']}}</td>
            <td><b>Search Term:</b> {{$filters['search']}}</td>
        </tr>
    </table>

    <table class="tb">
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
                <th>Status</th>
                <th>Qualified?</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scholarships as $scholarship)
                <tr>
                    <td>{{ $scholarship->student_number }}</td>
                    <td>{{ implode(' ', [$scholarship->first_name, $scholarship->middle_name, $scholarship->last_name])}}</td>
                    <td>{{ $scholarship->email}}</td>
                    <td>{{ $scholarship->school_year}} | {{ $scholarship->semester_name}}</td>
                    <td>{{ $scholarship->course}}</td>
                    <td>{{ $scholarship->gpa}}</td>
                    <td>{{ $scholarship->organization}}</td>
                    <td>{{ $scholarship->scholarship_type_name}}</td>
                    <td class="text-center"> 
                        <span style="color: 
                        @if ($scholarship->status_name == 'For Approval') #f57c00
                        @elseif ($scholarship->status_name == 'Approved') green
                        @elseif ($scholarship->status_name == 'Created') black
                        @endif
                        ">
                            {{ $scholarship->status_name}}
                        </span>
                    </td>
                    <td class="text-center">
                        @if ($scholarship->is_qualified)
                            Yes
                        @endif
                    </td>
                    <td>{{ $scholarship->remarks}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>