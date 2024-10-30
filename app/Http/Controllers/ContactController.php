<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactConfirmation;

class ContactController extends Controller
{
    
    // Method to display all contacts
    public function index(Request $request)
    {
        // Get the number of entries to show per page, defaulting to 10 if not specified
        $perPage = $request->input('entries', 10);
    
        // Get the search term from the request
        $searchTerm = $request->input('search', '');
    
        // Retrieve contacts with pagination, applying the search filter if provided
        $contacts = Contact::where('full_name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->orWhere('phone_number', 'like', "%{$searchTerm}%")
            ->paginate($perPage);
    
        return view('contact.index', compact('contacts', 'perPage', 'searchTerm')); // Pass data to view
    }       

    // Method to show the contact form
    public function create()
    {
        return view('welcome'); // Return your contact form view
    }

    // Method to store the contact message
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',            
            'phone_number' => 'required|string|max:11',
            'message' => 'required|string',  
        ]);

        $contact = Contact::create([
            'full_name' => $request->full_name, 
            'email' => $request->email,      
            'phone_number' => $request->phone_number, 
            'message' => $request->message,     
        ]);

        Mail::to($request->email)->send(new ContactConfirmation());

        \Log::info('Contact message sent successfully.');

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    // Method to show the edit form for a specific contact
    public function edit($id)
    {
        $contact = Contact::findOrFail($id); // Find contact by ID
        return view('contact.edit', compact('contact')); // Pass data to edit view
    }

    // Method to update a specific contact
    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255', 
            'email' => 'required|email',                
            'phone_number' => 'required|string|max:11', 
            'message' => 'required|string',              
        ]);

        $contact = Contact::findOrFail($id); 
        $contact->update([
            'full_name' => $request->full_name,  
            'email' => $request->email,            
            'phone_number' => $request->phone_number, 
            'message' => $request->message,       
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
        public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully!');
    }
}
