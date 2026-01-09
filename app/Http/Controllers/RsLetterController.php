<?php

namespace App\Http\Controllers;

use App\Models\RsLetter;
use Illuminate\Http\Request;

class RsLetterController extends Controller
{
public function store(Request $request, $id)
    {


        // 2. Data saving (update if exists, create if not)
        RsLetter::updateOrCreate(
            ['rstbl_id' => $id], // Condition to find the record (using the ID from the route)
            ['rs_letter' => $request->rs_letter] // Data to update/insert
        );

        // 3. Redirection with success message
        return redirect()->route('resource_speaker.masterlist')
            ->with('success', 'Specialist Letter Link saved successfully!');
    }
}
