<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::orderByDesc('updated_at')->with('images')->paginate(10);

        return view('announcement.list', ['announcements' => $announcements]);
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
        $announcement = Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => 'General',
            'created_by' => Auth::user()->id,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            foreach ($photo as $image) {
                $photoSaveAsName = Str::uuid().'-'.time().'-'.$announcement->id.'.'.$image->getClientOriginalExtension();
                $image->storeAs('announcements/'.$announcement->id, $photoSaveAsName);

                Image::create([
                    'image_name' => $photoSaveAsName,
                    'imageable_id' => $announcement->id,
                    'imageable_type' => Announcement::class,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Announcement successfully added');
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
        $data['announcement'] = Announcement::find($id);

        return view('announcement.edit', $data);
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
        $announcement = Announcement::findOrFail($id);
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => 'General',
            'updated_by' => Auth::user()->id,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            Storage::deleteDirectory('announcements/'.$announcement->id);
            $announcement->images()->delete();
            foreach ($photo as $image) {
                $photoSaveAsName = Str::uuid().'-'.time().'-'.$announcement->id.'.'.$image->getClientOriginalExtension();
                $image->storeAs('announcements/'.$announcement->id, $photoSaveAsName);

                Image::create([
                    'image_name' => $photoSaveAsName,
                    'imageable_id' => $announcement->id,
                    'imageable_type' => Announcement::class,
                ]);
            }
        }

        return redirect()->route('announcements.index')->with('message', 'Announcement successfully updated!');
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
        $announcement = Announcement::findOrFail($id)->delete();
        Storage::deleteDirectory('announcements/'.$id);

        return redirect()->back()->with('message', 'Record successfully deleted');
    }
}
