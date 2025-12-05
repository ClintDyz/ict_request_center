<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['position', 'divisionUnit'])->get();
        $positions = Position::all();
        $division_units = DivisionUnit::all();

        return view('users.index', compact('users', 'positions', 'division_units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id' => 'required|string|unique:users,emp_id',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'id_position' => 'nullable|exists:position,id',
            'id_division_unit' => 'nullable|exists:division_unit,id',
            'emp_type' => 'nullable|string',
            'roles' => 'nullable|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'is_active' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'emp_id' => ['required', 'string', Rule::unique('users', 'emp_id')->ignore($user->id)],
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'id_position' => 'nullable|exists:position,id',
            'id_division_unit' => 'nullable|exists:division_unit,id',
            'emp_type' => 'nullable|string',
            'roles' => 'nullable|string',
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'is_active' => 'required|boolean',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function profile()
{
    $user = auth()->user();
    return view('users.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'middlename' => 'nullable|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        'gender' => 'nullable|string',
    ]);

    $user->update($validated);

    return redirect()->route('users.profile')->with('success', 'Profile updated successfully!');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = auth()->user();

    // Check if current password is correct
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    // Update password
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return redirect()->route('users.profile')->with('success', 'Password changed successfully!');
}
public function resetPassword($id)
{
    try {
        $user = User::findOrFail($id);

        // Reset password to default
        $user->password = Hash::make('12345678');
        $user->save();

        return redirect()->back()->with('success', 'Password has been reset successfully for ' . $user->username . '. New password is: 12345678');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to reset password: ' . $e->getMessage());
    }
}
}
