<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['semesters'] = Semester::paginate(10);

        return view('semester.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester_name' => ['required', 'string', 'unique:semesters'],
        ]);

        Semester::create([
            'semester_name' => $request->semester_name,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('semesters.index')->with('message', 'Record successfully added!');
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
        $sem = Semester::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'semester_name' => ['required', 'string', 'unique:semesters,semester_name,'.$sem->id],
        ]);

        if ($validator->fails()) {
            $validator->errors()->add('semester_name_edit'.$sem->id, 'The semester name "'.$request->semester_name.'" has already been taken.');

            return redirect('semesters')->withErrors($validator)->with('modal_name', 'edit-modal-'.$sem->id)->withInput();
        }

        $sem->update([
            'semester_name' => $request->semester_name,
        ]);

        return redirect()->route('semesters.index')->with('message', 'Record successfully updated!');
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
        Semester::findOrFail($id)->delete();

        return redirect()->back()->with('message', 'Record successfully deleted');
    }
}
