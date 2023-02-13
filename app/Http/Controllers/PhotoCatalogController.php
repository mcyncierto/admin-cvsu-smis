<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\PhotoCatalog;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class PhotoCatalogController extends Controller
{
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
                ]);
            }

            $schoolYears = [];
            for ($y = 2021; $y <= date('Y'); ++$y) {
                $y2 = $y + 1;
                $schoolYears[] = $y.'-'.$y2;
            }

            $catalogs = $this->getData($request);
            $catalogs = $catalogs->orderByDesc('updated_at')->paginate(10);

            $data = [
                'catalogs' => $catalogs,
                'search' => $request->search,
                'semesters' => Semester::all()->toArray(),
                'school_years' => $schoolYears,
                'filter_semester' => $request->filter_semester,
                'filter_school_year' => $request->filter_school_year,
            ];
        }

        return view('photo-catalog.list', $data);
    }

    /**
     * Get Photo Catalog data from database, setup filters.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return object
     */
    private function getData($request)
    {
        $catalogs = PhotoCatalog::with('images')->with('semester');

        if (!empty($request->filter_school_year)) {
            $catalogs = $catalogs->where('school_year', "$request->filter_school_year");
        }

        if (!empty($request->filter_semester)) {
            $catalogs = $catalogs->where('semester_id', "$request->filter_semester");
        }

        if (isset($request->search) && $request->search != '') {
            $search = $request->search;

            $catalogs = $catalogs->whereRaw("(title LIKE '%$search%' OR description LIKE '%$search%')");
        }

        return $catalogs;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catalog = PhotoCatalog::create([
            'title' => $request->title,
            'description' => $request->description,
            'semester_id' => $request->semester,
            'school_year' => $request->school_year,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            foreach ($photo as $image) {
                $photoSaveAsName = Str::uuid().'-'.time().'-'.$catalog->id.'.'.$image->getClientOriginalExtension();
                $image->storeAs('photo-catalogs/'.$catalog->id, $photoSaveAsName);

                Image::create([
                    'image_name' => $photoSaveAsName,
                    'imageable_id' => $catalog->id,
                    'imageable_type' => PhotoCatalog::class,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Photo Catalog successfully added');
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
        $data['catalog'] = PhotoCatalog::find($id);
        $data['semester'] = Semester::all()->toArray();

        $data['school_year'] = [
            Carbon::now()->subYears(2)->format('Y').'-'.Carbon::now()->subYears(1)->format('Y'),
            Carbon::now()->subYears(1)->format('Y').'-'.Carbon::now()->format('Y'),
            Carbon::now()->format('Y').'-'.Carbon::now()->addYears(1)->format('Y'),
            Carbon::now()->addYears(1)->format('Y').'-'.Carbon::now()->addYears(2)->format('Y'),
        ];

        return view('photo-catalog.edit', $data);
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
        $catalog = PhotoCatalog::findOrFail($id);
        $catalog->update([
            'title' => $request->title,
            'description' => $request->description,
            'semester_id' => $request->semester,
            'school_year' => $request->school_year,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            Storage::deleteDirectory('photo-catalogs/'.$catalog->id);
            $catalog->images()->delete();
            foreach ($photo as $image) {
                $photoSaveAsName = Str::uuid().'-'.time().'-'.$catalog->id.'.'.$image->getClientOriginalExtension();
                $image->storeAs('photo-catalogs/'.$catalog->id, $photoSaveAsName);

                Image::create([
                    'image_name' => $photoSaveAsName,
                    'imageable_id' => $catalog->id,
                    'imageable_type' => PhotoCatalog::class,
                ]);
            }
        }

        return redirect()->route('photo-catalog.index')->with('message', 'Announcement successfully updated!');
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
        $catalog = PhotoCatalog::findOrFail($id)->delete();
        Storage::deleteDirectory('photo-catalogs/'.$id);

        return redirect()->back()->with('message', 'Record successfully deleted');
    }

    /**
     * Generate PDF.
     *
     * @return void
     */
    public function generatePDF(Request $request)
    {
        $data['filters'] = $request->all();
        $data['catalogs'] = $this->getData($request);
        $data['catalogs'] = $data['catalogs']->orderByDesc('updated_at')->get();
        $pdf = PDF::loadView('pdf/photo-catalogs-list', $data);

        return $pdf->download('photo-catalogs-list.pdf');
    }
}
