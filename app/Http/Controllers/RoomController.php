<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\ApartmentRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }
    public function show($id)
    {
        $room = Room::findOrFail($id);
        
        $events = ApartmentRoom::where('id', $id)->get();
        return view('rooms.details', compact('room', 'events')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
            'apartment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bathroom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'outside_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'occupied_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vacant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new room instance
        $room = new Room();
        $room->room_number = $request->room_number;
        $room->type = $request->type;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->available = $request->available;

        // Handle image uploads
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];
        
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $room->$field = $request->file($field)->store('rooms/images', 'public');
            }
        }

        // Save room to the database
        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
            'apartment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bathroom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'outside_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'occupied_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vacant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update room instance
        $room->room_number = $request->room_number;
        $room->type = $request->type;
        $room->price = $request->price;
        $room->capacity = $request->capacity;
        $room->description = $request->description;
        $room->available = $request->available;

        // Handle image updates
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old image if it exists
                if ($room->$field) {
                    Storage::disk('public')->delete($room->$field);
                }
                $room->$field = $request->file($field)->store('rooms/images', 'public');
            }
        }

        // Save updates to the database
        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Delete images from storage if they exist
        $imageFields = ['apartment_image', 'bathroom_image', 'outside_image', 'occupied_image', 'vacant_image'];

        foreach ($imageFields as $field) {
            if ($room->$field) {
                Storage::disk('public')->delete($room->$field);
            }
        }

        // Delete the room record
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
