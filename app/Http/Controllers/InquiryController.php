<?php

namespace App\Http\Controllers;

use App\Models\Inquiry; // Import the Inquiry model
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // Display a listing of inquiries
    public function index()
    {
        $inquiries = Inquiry::all(); // Retrieve all inquiries
        return view('inquiries.index', compact('inquiries')); // Pass inquiries to the view
    }

    // Show the form for creating a new inquiry
    public function create()
    {
        return view('inquiries.create'); // Return the create view
    }

    // Store a newly created inquiry in storage
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'price' => 'required|numeric', // Validate price as numeric
            'room_number' => 'required|string|max:255', // Validate room number
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'valid_id' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'agreement' => 'required|boolean',
        ]);

        // Handle file upload for valid ID
        $path = '';
        if ($request->hasFile('valid_id')) {
            $path = $request->file('valid_id')->store('valid_ids', 'public');
            \Log::info('File stored at: ' . $path); // Log the file path
        }

        // Create a new inquiry
        Inquiry::create([
            'price' => $request->price,
            'room_number' => $request->room_number,
            'full_name' => $request->full_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'valid_id' => $path,
            'agreement' => $request->agreement,
            'inquiry_status' => 'pending',
        ]);

        // Redirect back with a success message
        return response()->json(['message' => 'Inquiry submitted successfully.'], 200);
    }

    // Display the specified inquiry
    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Find the inquiry by ID or fail
        return view('inquiries.show', compact('inquiry')); // Pass inquiry to the view
    }

    // Show the form for editing the specified inquiry
    public function edit($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Find the inquiry by ID or fail
        return view('booking.forms', compact('inquiry')); // Pass inquiry to the edit view
    }

    // Update the specified inquiry in storage
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'price' => 'required|numeric',
            'room_number' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'valid_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Optional valid ID
            'agreement' => 'required|boolean',
        ]);

        // Find the inquiry by ID
        $inquiry = Inquiry::findOrFail($id);

        // Handle file upload for valid ID (if provided)
        $path = $inquiry->valid_id; // Keep the old path by default
        if ($request->hasFile('valid_id')) {
            // Delete the old file if it exists
            if ($path) {
                \Storage::disk('public')->delete($path);
            }
            // Store the new file
            $path = $request->file('valid_id')->store('valid_ids', 'public');
        }

        // Update the inquiry
        $inquiry->update([
            'price' => $request->price,
            'room_number' => $request->room_number,
            'full_name' => $request->full_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'valid_id' => $path,
            'agreement' => $request->agreement,
        ]);

        // Redirect back with a success message
        return redirect()->route('inquiries.index')->with('success', 'Inquiry updated successfully.');
    }

    // Remove the specified inquiry from storage
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Find the inquiry by ID or fail

        // Delete the file if it exists
        if ($inquiry->valid_id) {
            \Storage::disk('public')->delete($inquiry->valid_id);
        }

        $inquiry->delete(); // Delete the inquiry

        // Redirect back with a success message
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}