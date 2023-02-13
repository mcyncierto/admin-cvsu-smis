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

        .tb th,
        .tb td {
            border: 1px solid black;
            font-size: 11px
        }

        table.tb-borderless {
            border: 0px;
            font-size: 11px;
            margin-top: 20px;
        }

        .tb-borderless th,
        .tb-borderless td {
            border: 0px;
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
            margin: 0 auto;
            position: relative;
            text-align: center;
        }

        .content img {
            margin-right: 15px;
            float: left;
        }

        .content h3,
        .content p {
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
    <h3>Photo Catalog List Report</h3>
    <table style="font-size: 13px">
        <tr>
            <td><b>School Year:</b> {{ $filters['filter_school_year'] }}</td>
        </tr>
        <tr>
            <td><b>Semester:</b> {{ $filters['filter_semester'] }}</td>
            <td><b>Search Term:</b> {{ $filters['search'] }}</td>
        </tr>
    </table>
    <br><hr style="border: 1px dashed gray"><br>
    @foreach ($catalogs as $catalog)
        <table style="font-size: 12px; text-align: left">
            {{-- <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>School Year - Semester</th>
                </tr>
            </thead> --}}
            <tbody>
                <tr>
                    <td style="width: 150px"><b>Title: </b></td><td style="text-align: left">{{ $catalog->title }}</td>
                </tr>
                <tr>
                    <td style="width: 150px; vertical-align:top; padding-top: 8px"><b>Description: </b></td><td style="text-align: left"><br>{!! $catalog->description !!}</td>
                </tr>
                <tr>
                    <td style="width: 150px"><b>School Year - Semester: </b></td><td style="text-align: left">{{ $catalog->school_year }} | {{ $catalog->semester->semester_name }}</td>
                </tr>
                <tr>
                    <td style="width: 150px; padding-top: 8px"><b>Photos: </b></td>
                </tr>
            </tbody>
        </table>
        <table class="tb-borderless">
            <tbody>
                @if (count($catalog->images) > 0)
                    @foreach ($catalog->images as $image)
                        <tr>
                            <td style="text-align: center">
                                <br>
                                <img style="width: 70%"
                                    src="{{ asset('storage/photo-catalogs/' . $catalog->id . '/' . $image->image_name) }}">
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: center">
                            <i>No Photos Uploaded</i>
                        </td>
                    </tr>
                @endif
            </tbody>

        </table>
        <br><br>
        <hr style="border: 1px dashed gray"><br>
    @endforeach
</body>

</html>
