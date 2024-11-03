<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Apartment') }}
        </h2>
    </x-slot>

    <div class="w-full">
        <!-- Success Message -->
        @if(session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div id="errorMessage" class="bg-red-500 text-white p-2 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="min-h-full">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-400">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Contact Number</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Room Number</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Valid Id</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Agreement</th>
                            <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">ACCEPTANCE</th>
                            <th class="px-4 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-400">
                        @foreach ($inquiries as $slot)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-black">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->contact_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $slot->room_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                @if($slot->valid_id)
                                    <img src="{{ asset('storage/' . $slot->valid_id) }}" alt="Valid ID" class="h-10 w-10 object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                {{ $slot->agreement == 1 ? 'YES' : 'NO' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                <span class="{{ $slot->inquiry_status === 'pending' ? 'bg-yellow-500 text-black px-2 py-1 rounded' : ($slot->inquiry_status === 'successful' ? 'bg-green-500 text-white px-2 py-1 rounded' : 'text-black') }}">
                                    {{ $slot->inquiry_status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-black">
                                <div class="flex space-x-2">
                                    @if($slot->status === 1)
                                    <form id="approveForm{{ $slot->id }}" action="{{ route('inquiries.approved', $slot->id) }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="confirmAction('approveForm{{ $slot->id }}', 'Approved')" 
                                                class="flex items-center justify-center w-10 h-10 text-white bg-gray-600 hover:bg-gray-500 rounded-full focus:outline-none" 
                                                title="Mark as Approved">
                                            <i class="bi bi-chat-square-dots text-lg"></i>
                                        </button>
                                    </form>

                                    <button type="button" 
                                            class="flex items-center justify-center w-10 h-10 text-white bg-blue-600 hover:bg-blue-700 rounded-full focus:outline-none"
                                            data-bs-toggle="modal" data-bs-target="#editslotModal{{ $slot->id }}" 
                                            title="Edit">
                                        <i class="bi bi-pencil-square text-lg"></i>
                                    </button>

                                    <form id="deleteForm{{ $slot->id }}" action="{{ route('inquiries.destroy', $slot->id) }}" method="POST" class="delete-form inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                onclick="confirmDelete({{ $slot->id }})"
                                                class="flex items-center justify-center w-10 h-10 text-white bg-red-600 hover:bg-red-700 rounded-full focus:outline-none" 
                                                title="Delete">
                                            <i class="bi bi-trash3 text-lg"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form id="restoreForm{{ $slot->id }}" action="{{ route('slotmanagement.restore', $slot->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="button" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white hover:bg-green-500" onclick="confirmRestore('{{ $slot->id }}')" title="Restore">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Section -->
                
            </div>
        </div>
    </div>
</x-app-layout>

<!-- SweetAlert2 and Delete Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + id).submit();
        }
    });
}

function confirmRestore(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to restore this inquiry?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, restore it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('restoreForm' + id).submit();
        }
    });
}

function confirmAction(formId, action) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to " + action + " this inquiry?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + action + ' it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit(); // Submit the form
        }
    });
}
</script>

