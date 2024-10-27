<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Available Rooms') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addRoomModal">
            <i class="bi bi-house-add"></i> Add New Room
            </button>

            <div class="overflow-hidden shadow-md sm:rounded-lg">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600 w-42 text-center">Room Number</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Type</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Price</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Capacity</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Description</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Availability</th>
                            <th class="py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-4 text-sm text-gray-700 text-center">{{ $room->room_number }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 ">{{ $room->type }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">Php{{ number_format($room->price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->capacity }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->description }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->available ? 'Available' : 'Not Available' }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700 ">
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('rooms.destroy', $room) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete"><i class="bi bi-trash3"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Room Modal -->
                            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('rooms.update', $room) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group mb-4">
                                                    <label for="room_number">Room Number</label>
                                                    <input type="text" class="form-control" name="room_number" value="{{ $room->room_number }}" required>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="type">Room Type</label>
                                                    <input type="text" class="form-control" name="type" value="{{ $room->type }}" required>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="price">Price</label>
                                                    <input type="number" class="form-control" name="price" step="0.01" value="{{ $room->price }}" required>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="capacity">Capacity</label>
                                                    <input type="number" class="form-control" name="capacity" min="1" value="{{ $room->capacity }}" required>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description">{{ $room->description }}</textarea>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="available">Available</label>
                                                    <select class="form-control" name="available">
                                                        <option value="1" {{ $room->available ? 'selected' : '' }}>Yes</option>
                                                        <option value="0" {{ !$room->available ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="room_number">Room Number</label>
                            <input type="text" class="form-control" name="room_number" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="type">Room Type</label>
                            <input type="text" class="form-control" name="type" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" name="capacity" min="1" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="available">Available</label>
                            <select class="form-control" name="available">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
