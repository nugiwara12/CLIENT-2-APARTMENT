<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApartmentRoom;

class ApartmentRoomController extends Controller
{
    private const EVENT_COLORS = [
        'Test' => '#924ACE',
        'Test 1' => '#68B01A',
    ];

    public function index()
    {
        // Fetch all non-deleted apartment room bookings (status = 1)
        $events = ApartmentRoom::where('status', 1)->get()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_date,
                'end' => $booking->end_date,
                'color' => $this->getEventColor($booking->title), // Assuming this method returns a color based on the title
            ];
        });
    
        return view('booking.index', [
            'events' => $events,
            'eventCount' => $events->count(),
        ]);
    }    

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string',
                'full_name' => 'required|string',
                'contact_number' => 'required|string',
                'email' => 'required|email',
                'valid_id' => 'required|image|max:2048',
                'start_date' => 'required|date',
                'condition_agreement' => 'required|boolean',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            // Handle the valid ID upload if available
            if ($request->hasFile('valid_id')) {
                $path = $request->file('valid_id')->store('valid_ids', 'public');
                $validatedData['valid_id'] = $path;
            }

            // Create a new booking with the validated data
            $booking = ApartmentRoom::create($validatedData);

            return response()->json([
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_date,
                'end' => $booking->end_date,
                'color' => $this->getEventColor($booking->title),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function update(Request $request, $id)
    {
        $booking = ApartmentRoom::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Unable to locate the event'], 404);
        }

        try {
            // Validate the request
            $validatedData = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'full_name' => 'required|string',
                'contact_number' => 'required|string',
                'email' => 'required|email',
                'condition_agreement' => 'required|boolean',
                'valid_id' => 'nullable|image|max:2048', // Allow this to be nullable for updates
            ]);

            // Handle the valid ID update if a new file is uploaded
            if ($request->hasFile('valid_id')) {
                $path = $request->file('valid_id')->store('valid_ids', 'public');
                $validatedData['valid_id'] = $path;
            }

            // Update the booking with the validated data
            $booking->update($validatedData);

            return response()->json('Event updated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function destroy($id)
    {
        // Find the booking by ID
        $booking = ApartmentRoom::find($id);
    
        if (!$booking) {
            return response()->json(['error' => 'Unable to locate the event'], 404);
        }
    
        // Perform "soft delete" by setting the status to 0
        $booking->status = 0; // or whatever the status field is named
        $booking->save();
    
        return response()->json(['id' => $id]);
    }    

    private function getEventColor(string $title): ?string
    {
        return self::EVENT_COLORS[$title] ?? null;
    }
}
