<?php

namespace App\Http\Controllers;

use App\Imports\StudentRecordsImport;
use App\Models\Course;
use App\Models\Semester;
use App\Models\StudentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GpaCheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->action == 'reset') {
            $request->merge([
                'search' => '',
                'filter_school_year' => '',
                'filter_semester' => '',
                'filter_course' => '',
            ]);
        }

        $data['records'] = DB::table('student_records')
                        ->join('semesters', 'semester_id', '=', 'semesters.id')
                        ->leftjoin('users', 'student_records.student_number', '=', 'users.student_number')
                        ->select(
                            'users.student_number',
                            'users.first_name',
                            'users.middle_name',
                            'users.last_name',
                            'users.gender',
                            'users.email',
                            'semesters.semester_name',
                            'student_records.*'
                        );

        if (!empty($request->filter_school_year)) {
            $data['records'] = $data['records']->where('school_year', "$request->filter_school_year");
        }

        if (!empty($request->filter_semester)) {
            $data['records'] = $data['records']->where('semesters.semester_name', "$request->filter_semester");
        }

        if (!empty($request->filter_course)) {
            $data['records'] = $data['records']->where('course', "$request->filter_course");
        }

        if (isset($request->search)) {
            $search = $request->search;
            $data['records'] = $data['records']->whereRaw("(student_records.student_number LIKE '%$search%'
                    OR users.first_name LIKE '%$search%'
                    OR users.middle_name LIKE '%$search%'
                    OR users.last_name LIKE '%$search%'
                    OR users.email LIKE '%$search%'
                    OR student_records.course LIKE '%$search%'
                    OR student_records.gpa LIKE '%$search%'
                    OR semesters.semester_name LIKE '%$search%'
                )");
        }

        $currentSemester = Semester::where('is_current', 1)->first()->toArray();
        $data = [
            'records' => $data['records']->orderByDesc('updated_at')->paginate(10),
            'search' => $request->search,
            'current_semester' => [
                'id' => $currentSemester['id'],
                'semester_name' => $currentSemester['semester_name'],
            ],
            'school_year' => [
                Carbon::now()->format('Y').'-'.Carbon::now()->addYears(1)->format('Y'),
                Carbon::now()->addYears(1)->format('Y').'-'.Carbon::now()->addYears(2)->format('Y'),
            ],
        ];

        $data['courses'] = Course::all()->toArray();
        $data['semesters'] = Semester::all()->toArray();
        $data['school_years'] = [];
        for ($y = 2022; $y <= date('Y'); ++$y) {
            $y2 = $y + 1;
            $data['school_years'][] = $y.'-'.$y2;
        }
        $data['filter_course'] = $request->filter_course;
        $data['filter_semester'] = $request->filter_semester;
        $data['filter_school_year'] = $request->filter_school_year;

        return view('gpa-checker.create', $data);
    }

    /**
     * Store a newly created resource in storage and check qualified applicants.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Delete existing record w/ the same School Year and Semester
        StudentRecord::where('school_year', $request->school_year)->where('semester_id', $request->semester)->delete();

        if ($request->hasFile('file')) {
            \Excel::import(new StudentRecordsImport(), request()->file('file'));
        }

        $this->checkQualified();

        return redirect()->back()->with('message', 'Student Records successfully uploaded!');
    }

    /**
     * Check all applicants that are qualified for scholarship.
     *
     * @return void
     */
    private function checkQualified()
    {
        $scholarships = DB::table('scholarships AS s')
                            ->join('users AS u', 's.created_by', '=', 'u.id')
                            ->join('scholarship_types AS st', 's.scholarship_type_id', '=', 'st.id')
                            ->join('student_records AS sr', function ($join) {
                                $join->on('u.student_number', '=', 'sr.student_number')
                                    ->on('s.school_year', '=', 'sr.school_year')
                                    ->on('s.semester_id', '=', 'sr.semester_id');
                            })
                            ->join('semesters', 's.semester_id', '=', 'semesters.id')
                            ->where([
                                's.status' => 1,
                                'sr.is_enrolled' => 1,
                            ])
                            ->whereRaw(
                                'CASE
                                    WHEN st.highest_gpa_allowed IS NOT NULL AND st.lowest_gpa_allowed IS NOT NULL
                                        THEN sr.gpa BETWEEN st.highest_gpa_allowed AND st.lowest_gpa_allowed
                                    WHEN st.highest_gpa_allowed IS NULL AND st.lowest_gpa_allowed IS NOT NULL
                                        THEN sr.gpa <= st.lowest_gpa_allowed
                                        WHEN st.highest_gpa_allowed IS NOT NULL AND st.lowest_gpa_allowed IS NULL
                                        THEN sr.gpa >= st.highest_gpa_allowed
                                    ELSE 1=1
                                END'
                            )
                            ->whereRaw(
                                "CASE
                                    WHEN st.restrictions LIKE '%INC%' THEN sr.has_inc = 0
                                    ELSE sr.has_inc IN (0,1)
                                END"
                            )
                            ->whereRaw(
                                "CASE
                                    WHEN st.restrictions LIKE '%DROPPED%' THEN sr.has_dropped = 0
                                    ELSE sr.has_dropped IN (0,1)
                                END"
                            )->update(['s.is_qualified' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
