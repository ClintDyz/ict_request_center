<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Unit; // Changed from Province to Unit
use App\Models\Province;
use App\Models\Division;
use App\Models\Position;

use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); // Notice the variable is $users, not $Users
        $units = Unit::all(); // Fetch all units
        $provinces = Province::all();
        $divisions = Division::all();
        $positions = Position::all(); // Fetch all positions
        return view('accounts.index', compact('users', 'units', 'provinces', 'divisions', 'positions'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.create'); // Add this route if needed for creating a user form
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // Validate the input
        $request->validate([
            'emp_id' => 'required|string|max:191',
            'division' => 'nullable|string|max:191',
            'unit' => 'nullable|string|max:191',
            'province' => 'nullable|string|max:191',
            'region' => 'nullable|string|max:191',
            'groups' => 'nullable|string|max:191',
            'roles' => 'nullable|string|max:191',
            'firstname' => 'required|string|max:191',
            'middlename' => 'nullable|string|max:191',
            'lastname' => 'required|string|max:191',
            'gender' => 'required|string|max:191',
            'position' => 'nullable|string|max:191',
            'emp_type' => 'nullable|string|max:191',
            'username' => 'required|string|max:191|unique:users',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string',
            'mobile_no' => 'nullable|string|max:191',
            'last_login' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'current_team_id' => 'nullable|integer',
            'profile_photo_path' => 'nullable|string|max:2048',
        ]);

        // Create the new user
        $user = new User();
        $user->fill($request->except('password')); // Fill all fields except password
        $user->password = bcrypt($request->password); // Hash password before saving
        $user->save();

        // Redirect with success message
        return redirect()->route('accounts.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Fetch a specific user by ID
        return response()->json($user); // Return user data in JSON format
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Fetch the user by ID
        return view('accounts.edit', compact('user')); // Assuming 'accounts.edit' is the edit form
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'emp_id' => 'required|string|max:191',
            'division' => 'nullable|string|max:191',
            'unit' => 'nullable|string|max:191',
            'province' => 'nullable|string|max:191',
            'region' => 'nullable|string|max:191',
            'groups' => 'nullable|string|max:191',
            'firstname' => 'required|string|max:191',
            'middlename' => 'nullable|string|max:191',
            'lastname' => 'required|string|max:191',
            'gender' => 'nullable|string|max:191',
            'position' => 'nullable|string|max:191',
            'emp_type' => 'nullable|string|max:191',
            'username' => 'required|string|max:191|unique:users,username,' . $id,
            'email' => 'required|string|email|max:191|unique:users,email,' . $id,
            'address' => 'nullable|string',
            'password' => 'nullable|confirmed|min:8',
            'mobile_no' => 'nullable|string|max:191',
            'last_login' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'current_team_id' => 'nullable|integer',
            'profile_photo_path' => 'nullable|string|max:2048',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Fill the user model with all the validated request data
        $user->fill($request->except(['password'])); // Don't overwrite password unless provided

        // Handle password update (if password is provided)
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);
            $user->password = bcrypt($request->password);
        }

        // Save the updated user data
        $user->save();

        // Return a JSON response instead of a redirect
        return response()->json(['success' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        // Return a JSON response (or redirect if needed)
        return response()->json(['success' => 'User deleted successfully.']);
    }

}
