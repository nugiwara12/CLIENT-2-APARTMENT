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
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->type }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">Php{{ number_format($room->price, 2) }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->capacity }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->description }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">{{ $room->available ? 'Available' : 'Not Available' }}</td>
                                <td class="py-3 px-4 text-sm text-gray-700">
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
                                        <form action="{{ route('rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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



</x-app-layout>

<script>
function previewImage(event, previewId) {
    const preview = document.getElementById(previewId);
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}
</script>


