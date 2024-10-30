<div class="w-full">
    <!-- Success Message -->
    <x-modal.usermanagement.add-user />

    <div class="min-h-full">
        <div class="overflow-x-auto"> <!-- Enable horizontal scrolling on smaller screens -->
            <table class="min-w-full divide-y divide-gray-400">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-black uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-normal text-black uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-400">
                    @foreach ($users as $user)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-black">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                            <div class="flex space-x-2">
                                <!-- Edit Button -->
                                <button type="button" 
                                        class="bg-blue-600 text-white w-10 h-10 rounded-md hover:bg-blue-700 focus:outline-none flex justify-center items-center"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit">
                                    <i class="bi bi-pencil-square text-lg"></i>
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('usermanagement.destroy', $user->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="bg-red-600 text-white w-10 h-10 rounded-md hover:bg-red-700 focus:outline-none flex justify-center items-center delete-button" 
                                            title="Delete">
                                        <i class="bi bi-trash3 text-lg"></i>
                                    </button>
                                </form>
                            </div>    
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals for Edit User -->
@foreach ($users as $user)
    @include('components.modal.usermanagement.edit-user', ['user' => $user])
@endforeach

<!-- SweetAlert2 and Delete Confirmation Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all delete buttons
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent form submission
                const form = this.closest('.delete-form'); // Get the closest form element

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    });
</script>
