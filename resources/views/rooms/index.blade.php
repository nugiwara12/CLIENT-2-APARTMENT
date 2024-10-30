<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Available Rooms') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-4 lg:px-6">
            <div class="py-4">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="mr-4">
                <form method="GET" action="" class="relative justify-between flex items-center space-x-2 py-2">
                    <!-- Search Input -->
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-gray-500"></i>
                    </div>
                    <input type="search" id="search" name="search" value="{{ request('search') }}"
                        class="block max-w-md pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-sm transition duration-150 ease-in-out hover:border-blue-400"
                        placeholder="SEARCH" />
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                        <i class="bi bi-search text-gray-500"></i>
                    </button>
                    <button type="button" class="btn btn-primary whitespace-nowrap" data-toggle="modal" data-target="#addRoomModal">
                        <i class="bi bi-house-add"></i> Add New Room
                    </button>
                </form>
            </div>

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
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->type }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">Php{{ number_format($room->price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->capacity }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->description }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->available ? 'Available' : 'Not Available' }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">
                                    <div class="flex space-x-2">
                                        @if($room->status === 1)
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editRoomModal{{ $room->id }}" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form id="restoreForm{{ $room->id }}" action="{{ route('rooms.restore', $room->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $room->id }}')" title="Restore">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Room Modal -->
                            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                                                <div class="form-group mb-4">
                                                    <label for="room_number">Room Number</label>
                                                    <input type="text" class="form-control" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                                                    @error('room_number')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="type">Room Type</label>
                                                    <input type="text" class="form-control" name="type" value="{{ old('type', $room->type) }}" required>
                                                    @error('type')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="price">Price</label>
                                                    <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price', $room->price) }}" required>
                                                    @error('price')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="capacity">Capacity</label>
                                                    <input type="number" class="form-control" name="capacity" min="1" value="{{ old('capacity', $room->capacity) }}" required>
                                                    @error('capacity')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description">{{ old('description', $room->description) }}</textarea>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="available">Available</label>
                                                    <select class="form-control" name="available">
                                                        <option value="1" {{ old('available', $room->available) ? 'selected' : '' }}>Yes</option>
                                                        <option value="0" {{ old('available', !$room->available) ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>

                                                <!-- Apartment Image -->
                                                <div class="form-group mb-4">
                                                    <label for="apartment_image">Apartment Image</label>
                                                    @if ($room->apartment_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->apartment_image) }}" alt="Apartment Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="apartment_image" id="apartmentImageInput{{ $room->id }}" accept="image/*" onchange="previewImage(event, 'apartmentPreview{{ $room->id }}')">
                                                    <img id="apartmentPreview{{ $room->id }}" alt="Apartment Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Bathroom Image -->
                                                <div class="form-group mb-4">
                                                    <label for="bathroom_image">Bathroom Image</label>
                                                    @if ($room->bathroom_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->bathroom_image) }}" alt="Bathroom Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="bathroom_image" id="bathroomImageInput{{ $room->id }}" accept="image/*" onchange="previewImage(event, 'bathroomPreview{{ $room->id }}')">
                                                    <img id="bathroomPreview{{ $room->id }}" alt="Bathroom Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Outside Image -->
                                                <div class="form-group mb-4">
                                                    <label for="outside_image">Outside Image</label>
                                                    @if ($room->outside_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->outside_image) }}" alt="Outside Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="outside_image" id="outsideImageInput{{ $room->id }}" accept="image/*" onchange="previewImage(event, 'outsidePreview{{ $room->id }}')">
                                                    <img id="outsidePreview{{ $room->id }}" alt="Outside Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>

                                                <!-- Occupied Image -->
                                                <div class="form-group mb-4">
                                                    <label for="occupied_image">Occupied Image</label>
                                                    @if ($room->occupied_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->occupied_image) }}" alt="Occupied Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="occupied_image" id="occupiedImageInput{{ $room->id }}" accept="image/*" onchange="previewImage(event, 'occupiedPreview{{ $room->id }}')">
                                                    <img id="occupiedPreview{{ $room->id }}" alt="Occupied Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>
                                                <!-- Vacant Image -->
                                                <div class="form-group mb-4">
                                                    <label for="vacant_image">Vacant Image</label>
                                                    @if ($room->vacant_image)
                                                        <div>
                                                            <img src="{{ asset('storage/' . $room->vacant_image) }}" alt="Vacant Image" style="width: 100px; margin-right: 10px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control" name="vacant_image" id="vacantImageInput{{ $room->id }}" accept="image/*" onchange="previewImage(event, 'vacantPreview{{ $room->id }}')">
                                                    <img id="vacantPreview{{ $room->id }}" alt="Vacant Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body overflow-auto max-h-96 overflow-y-auto">
                        <div class="form-group mb-4">
                            <label for="room_number">Room Number</label>
                            <input type="text" class="form-control" name="room_number" value="{{ old('room_number') }}" required>
                            @error('room_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="type">Room Type</label>
                            <input type="text" class="form-control" name="type" value="{{ old('type') }}" required>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="capacity">Capacity</label>
                            <input type="number" class="form-control" name="capacity" min="1" value="{{ old('capacity') }}" required>
                            @error('capacity')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label for="available">Available</label>
                            <select class="form-control" name="available">
                                <option value="1" {{ old('available') ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('available') ? '' : 'selected' }}>No</option>
                            </select>
                        </div>
                        <!-- Room Images -->
                        <div class="form-group mb-4">
                            <label for="apartment_image">Apartment Image</label>
                            <input type="file" class="form-control" name="apartment_image" accept="image/*" onchange="previewImage(event, 'apartmentPreviewAdd')">
                            <img id="apartmentPreviewAdd" alt="Apartment Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="bathroom_image">Bathroom Image</label>
                            <input type="file" class="form-control" name="bathroom_image" accept="image/*" onchange="previewImage(event, 'bathroomPreviewAdd')">
                            <img id="bathroomPreviewAdd" alt="Bathroom Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="outside_image">Outside Image</label>
                            <input type="file" class="form-control" name="outside_image" accept="image/*" onchange="previewImage(event, 'outsidePreviewAdd')">
                            <img id="outsidePreviewAdd" alt="Outside Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="occupied_image">Occupied Image</label>
                            <input type="file" class="form-control" name="occupied_image" accept="image/*" onchange="previewImage(event, 'occupiedPreviewAdd')">
                            <img id="occupiedPreviewAdd" alt="Occupied Image Preview" style="width: 100px; margin-top: 10px; display: none;">
                        </div>
                        <div class="form-group mb-4">
                            <label for="vacant_image">Vacant Image</label>
                            <input type="file" class="form-control" name="vacant_image" accept="image/*" onchange="previewImage(event, 'vacantPreviewAdd')">
                            <img id="vacantPreviewAdd" alt="Vacant Image Preview" style="width: 100px; margin-top: 10px; display: none;">
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

    <script>
        function confirmRestore(roomId) {
            if (confirm("Are you sure you want to restore this room?")) {
                fetch('/rooms/restore/' + roomId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({}),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Room restored successfully!");
                        // Optionally, update the UI or remove the restore button.
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert("Failed to restore room.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while restoring the room.");
                });
            }
        }
    </script>
</x-app-layout>
