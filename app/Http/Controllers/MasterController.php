<?php

namespace App\Http\Controllers;

use App\Models\Dokter; // Import the Dokter model
use Illuminate\Http\Request; // Import the Request class

class MasterController extends Controller
{
    public function indexDokter()
    {
        $dokters = Dokter::all(); // Retrieve all doctors from the database
        return view('master.dokter', compact('dokters')); // Pass the doctors to the view
    }

    public function storeDokter(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama' => 'required|string|max:255', // Name is required and must be a string with a max length of 255
            'poli' => 'required|string|max:255', // Specialization is required and must be a string with a max length of 255
        ]);

        // Create a new doctor record in the database
        Dokter::create($request->all());
        // Redirect to the dokter index route with a success message
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function updateDokter(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'nama' => 'required|string|max:255', // Name is required and must be a string with a max length of 255
            'poli' => 'required|string|max:255', // Specialization is required and must be a string with a max length of 255
        ]);

        // Find the doctor by ID or fail
        $dokter = Dokter::findOrFail($id);
        // Update the doctor record with the new data
        $dokter->update($request->all());
        // Redirect to the dokter index route with a success message
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil diupdate.');
    }

    public function destroyDokter($id)
    {
        // Find the doctor by ID or fail
        $dokter = Dokter::findOrFail($id);
        // Delete the doctor record from the database
        $dokter->delete();
        // Redirect to the dokter index route with a success message
        return redirect()->route('dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
