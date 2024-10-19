<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApartmentRoom;

class ApartmentRoomController extends Controller
{
    // Define colors for event titles in a constant array
    private const EVENT_COLORS = [
        'Test' => '#924ACE',
        'Test 1' => '#68B01A',
    ];

    public function index()
    {
        // Fetch all apartment room bookings and map them to events with colors
        $events = ApartmentRoom::all()->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'start' => $booking->start_date,
                'end' => $booking->end_date,
                'color' => $this->getEventColor($booking->title),
            ];
        });

        $eventCount = $events->count(); // Count the events

        return view('booking.index', [
            'events' => $events,
            'eventCount' => $eventCount
        ]);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'full_name' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email',
            'valid_id' => 'required|image|max:2048', // Ensure valid ID is an image
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Handle the valid ID upload if available
        if ($request->hasFile('valid_id')) {
            $path = $request->file('valid_id')->store('valid_ids', 'public'); // Store in 'public/valid_ids'
            $validatedData['valid_id'] = $path; // Save path in the database
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
    }

    public function update(Request $request, $id)
    {
        $booking = ApartmentRoom::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Unable to locate the event'], 404);
        }

        // Validate the request
        $validatedData = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'full_name' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email',
            'valid_id' => 'required|image|max:2048', // Validate the image
        ]);

        // Handle the valid ID update if a new file is uploaded
        if ($request->hasFile('valid_id')) {
            $path = $request->file('valid_id')->store('valid_ids', 'public');
            $validatedData['valid_id'] = $path;
        }

        // Update the booking with the validated data
        $booking->update($validatedData);

        return response()->json('Event updated');
    }

    public function destroy($id)
    {
        $booking = ApartmentRoom::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Unable to locate the event'], 404);
        }

        $booking->delete();

        return response()->json(['id' => $id]);
    }

    // Method to get the color for a given event title
    private function getEventColor(string $title): ?string
    {
        return self::EVENT_COLORS[$title] ?? null; // Return the color or null if not found
    }
}
