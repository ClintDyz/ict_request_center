<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'emp_id' => 'required|string|max:191|unique:users,emp_id,' . $user->id,
            'firstname' => 'required|string|max:191',
            'middlename' => 'nullable|string|max:191',
            'lastname' => 'required|string|max:191',
            'gender' => 'nullable|string|max:191',
            'position' => 'nullable|string|max:191',
            'division' => 'nullable|string|max:191',
            'unit' => 'nullable|string|max:191',
            'province' => 'nullable|string|max:191',
            'region' => 'nullable|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'mobile_no' => 'nullable|string|max:191',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
                    Storage::delete($user->profile_photo_path);
                }

                // Store new photo
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $user->profile_photo_path = $path;
            }

            // Update user information
            $user->emp_id = $request->emp_id;
            $user->firstname = $request->firstname;
            $user->middlename = $request->middlename;
            $user->lastname = $request->lastname;
            $user->gender = $request->gender;
            $user->position = $request->position;
            $user->division = $request->division;
            $user->unit = $request->unit;
            $user->province = $request->province;
            $user->region = $request->region;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->address = $request->address;
            $user->save();

            return redirect()->route('profile.index')
                ->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating your profile: ' . $e->getMessage());
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please correct the errors below.');
        }

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect.');
        }

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('profile.index')
                ->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating your password.');
        }
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        try {
            if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
                Storage::delete($user->profile_photo_path);
                $user->profile_photo_path = null;
                $user->save();

                return redirect()->back()
                    ->with('success', 'Profile photo deleted successfully!');
            }

            return redirect()->back()
                ->with('error', 'No profile photo to delete.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while deleting your profile photo.');
        }
    }

    /**
     * Get user profile data as JSON (for API).
     */
    public function getProfile()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'emp_id' => $user->emp_id,
                'firstname' => $user->firstname,
                'middlename' => $user->middlename,
                'lastname' => $user->lastname,
                'fullname' => trim($user->firstname . ' ' . $user->middlename . ' ' . $user->lastname),
                'gender' => $user->gender,
                'position' => $user->position,
                'division' => $user->division,
                'unit' => $user->unit,
                'province' => $user->province,
                'region' => $user->region,
                'email' => $user->email,
                'mobile_no' => $user->mobile_no,
                'address' => $user->address,
                'profile_photo_url' => $user->profile_photo_path
                    ? Storage::url($user->profile_photo_path)
                    : asset('images/default-avatar.png'),
                'email_verified' => $user->email_verified_at !== null,
                'is_active' => $user->is_active,
                'last_login' => $user->last_login,
                'created_at' => $user->created_at,
            ]
        ]);
    }
}
