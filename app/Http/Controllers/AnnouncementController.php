<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::orderByDesc('updated_at')->paginate(10);

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
            'type' => $request->type,
            'created_by' => Auth::user()->id,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            $photoSaveAsName = time().$announcement->id.'-photo.'.$photo->getClientOriginalExtension();
            request()->file('photo')->storeAs('announcements', $photoSaveAsName);
            $announcement->update(['photo' => $photoSaveAsName]);
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
            'type' => $request->type,
            'updated_by' => Auth::user()->id,
        ]);

        $photoSaveAsName = '';
        if (request()->hasFile('photo')) {
            $photo = request()->photo;
            $photoSaveAsName = time().$announcement->id.'-photo.'.$photo->getClientOriginalExtension();
            Storage::delete('announcements/'.$announcement->photo);
            request()->file('photo')->storeAs('announcements', $photoSaveAsName);
            $announcement->update(['photo' => $photoSaveAsName]);
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

        return redirect()->back()->with('message', 'Record successfully deleted');
    }
}
