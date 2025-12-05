<?php

namespace App\Http\Controllers;

use App\Models\IDRequest;
use App\Models\Position;
use App\Models\DivisionUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IDRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_requests = IDRequest::with(['position', 'divisionUnit'])->get();
        $positions = Position::all();
        $division_units = DivisionUnit::all();

        return view('id_request.index', compact('id_requests', 'positions', 'division_units'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        $validated = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'nick_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'blood_type' => 'required|string',
            'id_position' => 'required|exists:position,id',
            'id_division_unit' => 'required|exists:division_unit,id',
            'status' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string',
            'emergency_contact_number' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'nullable|string',
            'valid_until' => 'nullable|date|after:today'
        ]);

        // Handle photo upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        // Handle signature from canvas (base64)
        if ($request->filled('signature') && strpos($request->signature, 'data:image') === 0) {
            // Extract base64 data
            $signatureData = $request->signature;
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
            $signatureData = str_replace(' ', '+', $signatureData);
            $signatureImage = base64_decode($signatureData);

            // Create filename
            $fileName = 'signature_' . time() . '_' . uniqid() . '.png';
            $path = 'signatures/' . $fileName;

            // Save to storage
            $fullPath = storage_path('app/public/' . $path);

            // Create directory if it doesn't exist
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Save the PNG file
            file_put_contents($fullPath, $signatureImage);

            $validated['signature'] = $path;
        }

        // Set default valid_until to 1 year from now if not provided
        if (empty($validated['valid_until'])) {
            $validated['valid_until'] = now()->addYear()->format('Y-m-d');
        }

        IDRequest::create($validated);

        return redirect()->route('id_request.index')
            ->with('success', 'ID Request created successfully.');
    }

    public function update(Request $request, $id)
    {
        $id_request = IDRequest::findOrFail($id);

        $validated = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'nick_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'blood_type' => 'required|string',
            'id_position' => 'required|exists:position,id',
            'id_division_unit' => 'required|exists:division_unit,id',
            'status' => 'required|string',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string',
            'emergency_contact_number' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature' => 'image|mimes:jpeg,png,jpg|max:1024',
            'valid_until' => 'nullable|date'
        ]);

        // Handle photo upload
        if ($request->hasFile('image')) {
            if ($id_request->image) {
                Storage::disk('public')->delete($id_request->image);
            }
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        // Handle signature upload - convert to PNG
        if ($request->hasFile('signature')) {
            // Delete old signature
            if ($id_request->signature) {
                Storage::disk('public')->delete($id_request->signature);
            }

            $signatureFile = $request->file('signature');
            $fileName = 'signature_' . time() . '_' . uniqid() . '.png';
            $path = 'signatures/' . $fileName;

            // Save as PNG with transparency
            $img = imagecreatefromstring(file_get_contents($signatureFile->getRealPath()));

            // Enable alpha blending and save alpha channel
            imagealphablending($img, false);
            imagesavealpha($img, true);

            // Save to storage
            $fullPath = storage_path('app/public/' . $path);

            // Create directory if it doesn't exist
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            imagepng($img, $fullPath, 9);
            imagedestroy($img);

            $validated['signature'] = $path;
        }

        $id_request->update($validated);

        return redirect()->route('id_request.index')
            ->with('success', 'ID Request updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id_request = IDRequest::findOrFail($id);

        // Delete image if exists
        if ($id_request->image) {
            Storage::disk('public')->delete($id_request->image);
        }

        $id_request->delete();

        return redirect()->route('id_request.index')
            ->with('success', 'ID Request deleted successfully.');
    }
}
