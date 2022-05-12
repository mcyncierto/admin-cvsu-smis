<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PDF;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->getData($request);

        if ($request->action == 'generate-pdf') {
            return $this->generatePDF($request);
        } else {
            $users = $users->paginate(10);
        }

        return view('user.list', ['users' => $users, 'search' => $request->search]);
    }

    /**
     * Get Users data from database, setup filters.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return object
     */
    private function getData($request)
    {
        if (isset($request->search)) {
            $search = $request->search;
            $users = User::where('student_number', 'LIKE', "%$search%")
                    ->orWhere('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('birthdate', 'LIKE', "%$search%")
                    ->orWhere('gender', 'LIKE', "%$search%")
                    ->orWhere('contact_number', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('type', 'LIKE', "%$search%")
                    ->orderByDesc('updated_at');
        } else {
            $users = User::orderByDesc('updated_at');
        }

        return $users;
    }

    /**
     * Generate PDF.
     *
     * @return void
     */
    public function generatePDF(Request $request)
    {
        $data['filters'] = $request->all();
        $data['users'] = $this->getData($request);
        $data['users'] = $data['users']->get();
        $pdf = PDF::loadView('pdf/users-list', $data);

        return $pdf->download('users-list.pdf');
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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'digits:11'],
            'address' => ['required', 'string'],
            'email' => 'required|string|email|max:255',
        ];

        if (!is_null($request->password)) {
            $rules += [
                'password' => 'string|min:8',
                'password_confirmation' => 'same:password',
            ];
        }

        $user = User::findOrFail($id);
        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            'email' => $request->email,
        ]);

        if (!empty($request->password)) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $profileImageSaveAsName = '';
        if (request()->hasFile('profile_picture')) {
            $profileImage = request()->profile_picture;
            $profileImageSaveAsName = time().$id.'-profile.'.$profileImage->getClientOriginalExtension();
            Storage::delete('profile-pictures/'.$user->profile_picture);
            request()->file('profile_picture')->storeAs('profile-pictures', $profileImageSaveAsName);
            $user->update(['profile_picture' => $profileImageSaveAsName]);
        }

        return redirect()->back()->with('message', 'User successfully updated');
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
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('message', 'User successfully deleted');
    }
}
