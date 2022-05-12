<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
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
    <h3>Users List Report</h3>
    <table style="font-size: 13px">
        <tr>
            <td><b>Search Term:</b> {{$filters['search']}}</td>
        </tr>
    </table>

    <table class="tb">
        <thead>
            <tr>
                <th>Student Number/Number Code</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Email</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->student_number }}</td>
                    <td>{{ $user->first_name}}</td>
                    <td>{{ $user->middle_name}}</td>
                    <td>{{ $user->last_name}}</td>
                    <td>{{ $user->birthdate}}</td>
                    <td>{{ $user->gender}}</td>
                    <td>{{ $user->contact_number}}</td>
                    <td>{{ $user->address}}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>