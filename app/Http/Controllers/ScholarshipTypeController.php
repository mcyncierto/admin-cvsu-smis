<?php

namespace App\Http\Controllers;

use App\Models\RequirementType;
use App\Models\ScholarshipType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScholarshipTypeController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['scholarshipTypes'] = DB::table('scholarship_types AS st')
            ->select('st.*',
                DB::raw("(SELECT GROUP_CONCAT(rt.requirement_name SEPARATOR ', ')
                FROM requirement_types rt
                WHERE rt.scholarship_type_id = st.id
                GROUP BY rt.scholarship_type_id) AS requirements")
            )->paginate(10);

        return view('scholarship-type.list', $data);
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
            'scholarship_type_name' => ['required', 'string', 'unique:scholarship_types'],
        ]);

        $scholarshipType = ScholarshipType::create([
            'scholarship_type_name' => $request->scholarship_type_name,
            'description' => $request->description,
            'lowest_gpa_allowed' => $request->lowest_gpa_allowed,
            'highest_gpa_allowed' => $request->highest_gpa_allowed,
            'restrictions' => $request->restrictions,
            'created_by' => Auth::user()->id,
        ]);

        $requirementTypesValues = explode(',', $request->requirements);

        if (count($requirementTypesValues) > 0) {
            foreach ($requirementTypesValues as $val) {
                if (trim($val) != '') {
                    RequirementType::create([
                        'scholarship_type_id' => $scholarshipType->id,
                        'requirement_name' => trim($val),
                    ]);
                }
            }
        }

        return redirect()->route('scholarship-types.index')->with('message', 'Record successfully added!');
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
        $scholarshipType = ScholarshipType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'scholarship_type_name' => ['required', 'string', 'unique:scholarship_types,scholarship_type_name,'.$scholarshipType->id],
        ]);

        if ($validator->fails()) {
            $validator->errors()->add('scholarship_type_name_edit'.$scholarshipType->id, 'The scholarship type name "'.$request->scholarship_type_name.'" has already been taken.');

            return redirect('scholarship-types')->withErrors($validator)->with('modal_name', 'edit-modal-'.$scholarshipType->id)->withInput();
        }

        $scholarshipType->update([
            'scholarship_type_name' => $request->scholarship_type_name,
            'description' => $request->description,
            'lowest_gpa_allowed' => $request->lowest_gpa_allowed,
            'highest_gpa_allowed' => $request->highest_gpa_allowed,
            'restrictions' => $request->restrictions,
        ]);

        $requirementTypesValues = explode(',', $request->requirements);

        if (count($requirementTypesValues) > 0) {
            $scholarshipType->requirementTypes()->delete();
            foreach ($requirementTypesValues as $val) {
                if (trim($val) != '') {
                    RequirementType::create([
                        'scholarship_type_id' => $scholarshipType->id,
                        'requirement_name' => trim($val),
                    ]);
                }
            }
        }

        return redirect()->route('scholarship-types.index')->with('message', 'Record successfully updated!');
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
        ScholarshipType::findOrFail($id)->delete();

        return redirect()->back()->with('message', 'Record successfully deleted');
    }
}
