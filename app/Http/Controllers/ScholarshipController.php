<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Scholarship;
use App\Models\ScholarshipRequirement;
use App\Models\ScholarshipType;
use App\Models\Semester;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class ScholarshipController extends Controller
{
    use ApiResponser;

    private $remarksOptions = [
        'Complete Requirements',
        'Incomplete Requirements',
        'Not qualified for the required GPA',
        'Others',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->action == 'generate-pdf') {
            return $this->generatePDF($request);
        } else {
            if ($request->action == 'reset') {
                $request->merge([
                    'search' => '',
                    'filter_school_year' => '',
                    'filter_semester' => '',
                    'filter_course' => '',
                    'filter_scholarship_type' => '',
                ]);
            }

            $scholarships = $this->getData($request);
            $scholarships = $scholarships->orderByDesc('s.updated_at')->paginate(20);

            $courses = Course::all()->toArray();
            $semesters = Semester::all()->toArray();
            $scholarshipTypes = ScholarshipType::all()->toArray();
            $school_years = [];
            for ($y = 2021; $y <= date('Y'); ++$y) {
                $y2 = $y + 1;
                $school_years[] = $y.'-'.$y2;
            }

            return view('scholarship.list', [
                'scholarships' => $scholarships,
                'search' => $request->search,
                'semesters' => $semesters,
                'school_years' => $school_years,
                'courses' => $courses,
                'scholarship_types' => $scholarshipTypes,
                'filter_course' => $request->filter_course,
                'filter_semester' => $request->filter_semester,
                'filter_school_year' => $request->filter_school_year,
                'filter_scholarship_type' => $request->filter_scholarship_type,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['requirements'] = DB::table('scholarship_types AS st')
            ->select('st.*',
                DB::raw("(SELECT GROUP_CONCAT(rt.requirement_name SEPARATOR ', ')
                FROM requirement_types rt
                WHERE rt.scholarship_type_id = st.id
                GROUP BY rt.scholarship_type_id) AS requirements")
            )->get();

        $data['semester'] = Semester::all()->toArray();

        $data['school_year'] = [
            Carbon::now()->subYears(1)->format('Y').'-'.Carbon::now()->format('Y'),
            Carbon::now()->format('Y').'-'.Carbon::now()->addYears(1)->format('Y'),
            Carbon::now()->addYears(1)->format('Y').'-'.Carbon::now()->addYears(2)->format('Y'),
        ];

        $data['scholarship_type'] = ScholarshipType::all()->toArray();

        return view('scholarship.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($request->action) {
            case 'save_for_later':
                $status = 0;
                break;

            case 'for_approval':
                $status = 1;
                break;
        }

        $scholarship = Scholarship::create([
            'semester_id' => $request->semester,
            'school_year' => $request->school_year,
            'scholarship_type_id' => $request->scholarship_type,
            'gpa' => $request->gpa,
            'status' => $status,
            'organization' => $request->org,
            'created_by' => Auth::user()->id,
        ]);

        $params = [
            'method' => 'create',
            'scholarship_id' => $scholarship->id,
        ];
        $this->saveFiles($request, $params);

        return redirect()->route('scholarships.index')->with('message', 'Application submitted!');
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
        $data['scholarship'] = DB::table('scholarships AS s')
                            ->leftJoin('users AS u', 's.created_by', '=', 'u.id')
                            ->leftJoin('student_records AS sr', function ($join) {
                                $join->on('u.student_number', '=', 'sr.student_number')
                                    ->on('s.school_year', '=', 'sr.school_year')
                                    ->on('s.semester_id', '=', 'sr.semester_id');
                            })
                            ->select(
                                's.*',
                                'sr.gpa'
                            )
                            ->where('s.id', $id)->first();

        if (Auth::user()->id != $data['scholarship']->created_by && Auth::user()->type != 'Admin') {
            abort(401);
        }

        $data['semester'] = Semester::all()->toArray();

        $data['school_year'] = [
            Carbon::now()->subYears(2)->format('Y').'-'.Carbon::now()->subYears(1)->format('Y'),
            Carbon::now()->subYears(1)->format('Y').'-'.Carbon::now()->format('Y'),
            Carbon::now()->format('Y').'-'.Carbon::now()->addYears(1)->format('Y'),
            Carbon::now()->addYears(1)->format('Y').'-'.Carbon::now()->addYears(2)->format('Y'),
        ];

        $data['scholarship_type'] = ScholarshipType::all()->toArray();
        $data['requirements'] = ScholarshipRequirement::where('scholarship_id', $id)->get();
        $data['remarks_options'] = $this->remarksOptions;

        if (!in_array($data['scholarship']->remarks, $data['remarks_options'])) {
            $data['scholarship']->remarks_others = $data['scholarship']->remarks;
        } else {
            $data['scholarship']->remarks_others = '';
        }

        return view('scholarship.edit', $data);
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
        switch ($request->action) {
            case 'disapprove':
            case 'save_for_later':
                $status = 0;
                break;

            case 'for_approval':
                $status = 1;
                break;

            case 'approve':
                $status = 2;
                break;
        }

        $scholarship = Scholarship::findOrFail($id);

        if ($request->remarks == 'Others' && !empty($request->remarks_others)) {
            $remarksValue = $request->remarks_others;
        } else {
            $remarksValue = $request->remarks;
        }

        $scholarship->update([
            'semester_id' => $request->semester,
            'school_year' => $request->school_year,
            'scholarship_type_id' => $request->scholarship_type,
            'gpa' => $request->gpa,
            'status' => $status,
            'remarks' => $remarksValue,
            'organization' => $request->org,
        ]);

        $params = [
            'method' => 'update',
            'scholarship_id' => $id,
        ];
        $this->saveFiles($request, $params);

        return redirect()->route('scholarships.index')->with('message', 'Application updated!');
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
        $scholarship = Scholarship::findOrFail($id)->delete();

        return redirect()->back()->with('message', 'Record successfully deleted');
    }

    /**
     * Get Scholarship data from database, setup filters.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return object
     */
    private function getData($request)
    {
        $scholarships = DB::table('scholarships AS s')
                            ->leftJoin('users AS u', 's.created_by', '=', 'u.id')
                            ->leftJoin('scholarship_types AS st', 's.scholarship_type_id', '=', 'st.id')
                            ->leftJoin('student_records AS sr', function ($join) {
                                $join->on('u.student_number', '=', 'sr.student_number')
                                    ->on('s.school_year', '=', 'sr.school_year')
                                    ->on('s.semester_id', '=', 'sr.semester_id');
                            })
                            ->leftJoin('semesters', 's.semester_id', '=', 'semesters.id')
                            ->select(
                                'u.student_number',
                                'u.first_name',
                                'u.middle_name',
                                'u.last_name',
                                'u.gender',
                                'u.email',
                                'semesters.semester_name',
                                's.*',
                                'sr.course',
                                'sr.gpa',
                                DB::raw(
                                    "(CASE 
                                        WHEN s.status = 0 THEN 'Created'
                                        WHEN s.status = 1 THEN 'For Approval'
                                        WHEN s.status = 2 THEN 'Approved'
                                        WHEN s.status = 3 THEN 'Closed'
                                    END) AS status_name"
                                ),
                                'st.scholarship_type_name'
                            )->distinct();

        if (!empty($request->filter_school_year)) {
            $scholarships = $scholarships->where('s.school_year', "$request->filter_school_year");
        }

        if (!empty($request->filter_semester)) {
            $scholarships = $scholarships->where('semesters.semester_name', "$request->filter_semester");
        }

        if (!empty($request->filter_course)) {
            $scholarships = $scholarships->where('sr.course', "$request->filter_course");
        }

        if (!empty($request->filter_scholarship_type)) {
            $scholarships = $scholarships->where('st.scholarship_type_name', "$request->filter_scholarship_type");
        }

        if (isset($request->search)) {
            $search = $request->search;

            $searchStatus = null;
            if (str_contains('created', Str::lower($search))) {
                $searchStatus = 0;
            } elseif (Str::contains('for approval', Str::lower($search))) {
                $searchStatus = 1;
            } elseif (Str::contains('approved', Str::lower($search))) {
                $searchStatus = 2;
            } elseif (Str::contains('closed', Str::lower($search))) {
                $searchStatus = 3;
            }
            $filterStatus = is_null($searchStatus) ? $search : $searchStatus;
            $scholarships = $scholarships->whereRaw("(u.student_number LIKE '%$search%'
                    OR u.first_name  LIKE '%$search%'
                    OR u.middle_name LIKE '%$search%'
                    OR u.last_name LIKE '%$search%'
                    OR u.gender LIKE '%$search%'
                    OR u.email LIKE '%$search%'
                    OR semesters.semester_name LIKE '%$search%'
                    OR s.school_year LIKE '%$search%'
                    OR sr.course LIKE '%$search%'
                    OR sr.gpa LIKE '%$search%'
                    OR s.organization LIKE '%$search%'
                    OR s.remarks LIKE '%$search%'
                    OR s.status LIKE '%$filterStatus%'
                    OR st.scholarship_type_name LIKE '%$search%'
                )");
        }

        if (Auth::user()->type == 'Student') {
            $scholarships = $scholarships->where('s.created_by', Auth::user()->id);
        }

        return $scholarships;
    }

    /**
     * Save files to storage.
     *
     * @return array
     */
    private function saveFiles(Request $request, $data)
    {
        $scolarshipId = $data['scholarship_id'];

        if ($request->hasFile('attachment')) {
            // Delete previous uploaded files if update to replace with new files.
            if ($data['method'] == 'update') {
                $oldReqs = ScholarshipRequirement::where('scholarship_id', $scolarshipId)->get();
                foreach ($oldReqs as $req) {
                    Storage::delete('scholarships\\requirements\\'.$scolarshipId.'\\'.$req['attachment']);
                }
                ScholarshipRequirement::where('scholarship_id', $scolarshipId)->delete();
            }

            $fileData = [];
            $files = $request->file('attachment');
            foreach ($files as $file) {
                $fileName = explode('.', $file->getClientOriginalName())[0].'-'.uniqid().'-'.$scolarshipId.'.'.$file->extension();
                $file->storeAs('scholarships/requirements/'.$scolarshipId, $fileName);

                // Force Convert to PDF
                if ($file->extension() != 'pdf') {
                    $data = ['id' => $scolarshipId, 'complete_file_name' => $fileName, 'orig_file_name' => explode('.', $file->getClientOriginalName())[0]];
                    $fileName = $this->convertToPDF($data);
                }

                $fileData[] = [
                    'scholarship_id' => $scolarshipId,
                    'attachment' => $fileName,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
                ];
            }
            ScholarshipRequirement::insert($fileData);
        }
    }

    /**
     * Force convert .doc/.docx files to pdf.
     *
     * @return string
     */
    private function convertToPDF($data)
    {
        $storageAppPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $id = $data['id'];
        $completeFileName = $data['complete_file_name'];
        $origFileName = $data['orig_file_name'];
        /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        // Load word file
        $path = 'public\\scholarships\\requirements\\'.$id.'\\';
        $Content = \PhpOffice\PhpWord\IOFactory::load($storageAppPath.$path.$completeFileName);

        // Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $pdfFileName = $origFileName.'-'.uniqid().'-'.$id.'.pdf';
        $PDFWriter->save($storageAppPath.$path.$pdfFileName);
        Storage::delete('scholarships\\requirements\\'.$id.'\\'.$completeFileName);

        return $pdfFileName;
    }

    /**
     * Open pdf attachment in new tab.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAttachment($id, $fileName)
    {
        $headers = ['Content-Type' => 'application/pdf'];
        $storageAppPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        return response()->file($storageAppPath."\public\scholarships\\requirements\\".$id.'\\'.$fileName, $headers);
    }

    /**
     * Generate PDF.
     *
     * @return void
     */
    public function generatePDF(Request $request)
    {
        $data['filters'] = $request->all();
        $data['scholarships'] = $this->getData($request);
        $data['scholarships'] = $data['scholarships']->orderByDesc('s.updated_at')->get();
        $pdf = PDF::loadView('pdf/scholarship-applications-list', $data);

        return $pdf->download('scholarship-applications-list.pdf');
    }
}
