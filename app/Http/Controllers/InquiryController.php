<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['messages'] = DB::table('inquiries AS i')
                    ->join('users AS u', 'i.created_by', '=', 'u.id')
                    ->whereIn('i.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))->from('inquiries')->groupby('student_id');
                    });

        if (isset($request->search)) {
            $search = $request->search;

            $data['messages'] = $data['messages']->whereRaw("
                (u.first_name LIKE '%$search%'
                OR u.middle_name LIKE '%$search%'
                OR u.last_name LIKE '%$search%'
                OR i.content LIKE '%$search%')
            ");
        }

        $data['messages'] = $data['messages']->select(
            'i.*',
            'u.student_number',
            'u.first_name',
            'u.middle_name',
            'u.last_name',
            'u.type',
            'u.profile_picture',
        )->orderByDesc('created_at')->paginate(20);

        $data['search'] = $request->search;

        return view('inquiry.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $studentId = null)
    {
        if (Auth::user()->type == 'Admin') {
            // Update message as read
            Inquiry::where('student_id', $studentId)
                    ->where('created_by', $studentId)
                    ->orderByDesc('created_at')->first()
                    ->update(['is_read' => 1]);
        } else {
            Inquiry::where('student_id', Auth::user()->id)
                    ->where('created_by', '<>', Auth::user()->id)
                    ->update(['is_read' => 1]);
        }

        if (Auth::user()->type == 'Admin') {
            $id = $studentId;
        } else {
            $id = Auth::user()->id;
        }

        $data['student_id'] = $id;

        $data['messages'] = DB::table('inquiries AS i')
                    ->join('users AS u', 'i.created_by', '=', 'u.id')
                    ->where('student_id', $id)
                    ->select(
                        'i.*',
                        'u.student_number',
                        'u.first_name',
                        'u.middle_name',
                        'u.last_name',
                        'u.type',
                        'u.profile_picture',
                    )->orderBy('created_at')->get();

        return view('inquiry.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inquiry = Inquiry::create([
            'content' => $request->content,
            'student_id' => $request->student_id,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('inquiries.create', $request->student_id)->with('message', 'Message submitted!');
    }
}
