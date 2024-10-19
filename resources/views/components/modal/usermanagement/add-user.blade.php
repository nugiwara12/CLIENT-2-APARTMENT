<div class="px-2 border-b bg-gray-50 rounded-lg">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-bold">Add Users</h3>
        <div class="flex justify-end mb-2">
            <!-- Button to open the Add Users modal -->
            <button class="bg-[#1B76B5] p-2 rounded-md text-white hover:text-white" id="openAddModalButton">
                <i class="bi bi-person-plus"></i> Add Users
            </button>
        </div>
    </div>
</div>

<!-- Add Users Modal -->
<div id="addModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex justify-center items-center transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="addModalContent">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h5 class="text-lg font-bold" id="addModalLabel">Register Account</h5>
            <button type="button" class="text-3xl" id="closeAddModalButton">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="p-3 overflow-auto">
            <div class="flex justify-center">
                <!-- Add Form -->
                <form id="userRegistrationForm" class="w-full space-y-4">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
                        <x-text-input id="name" class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" type="text" name="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="text-red-500 text-sm mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                        <x-text-input id="email" class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" type="email" name="email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-2" />
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <x-input-label for="role" :value="__('Role')" class="text-gray-700 font-semibold" />
                        <select id="role" name="role" class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="" disabled selected>{{ __('Select Role') }}</option>
                            <option value="admin">{{ __('Admin') }}</option>
                            <option value="tenant">{{ __('Tenant') }}</option>
                            <option value="User">{{ __('User') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="text-red-500 text-sm mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                        <x-text-input id="password" class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-sm mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="w-full lg:w-auto bg-[#1B76B5] text-white p-2 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    // Add Users modal open/close
    $('#openAddModalButton').on('click', function() {
        $('#addModal').removeClass('hidden');
        $('#addModalContent').removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100');
    });

    $('#closeAddModalButton').on('click', function() {
        $('#addModalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
        setTimeout(function() {
            $('#addModal').addClass('hidden');
        }, 300); // Match the timeout with the duration of the fade effect
    });

    // Submit form via AJAX
    $('#userRegistrationForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('usermanagement.store') }}", // Your Laravel route for storing users
            type: "POST",
            data: formData,
            success: function(response) {
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: 'User registered successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Close the modal and reset the form
                    $('#addModalContent').removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(function() {
                        $('#addModal').addClass('hidden'); // Close the modal
                        $('#userRegistrationForm')[0].reset(); // Reset the form
                        window.location.reload();
                    }, 300); // Match the timeout with the duration of the fade effect
                });
            },
            error: function(xhr) {
                // Show error message
                var errorMessage = 'Registration failed. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    });
});

// Add Users modal function
const openModalButton = document.getElementById('openAddModalButton');
const closeModalButton = document.getElementById('closeAddModalButton');
const modal = document.getElementById('addModal');
const modalContent = document.getElementById('addModalContent');

// Open the modal
openModalButton.addEventListener('click', () => {
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-175', 'opacity-50');
    }, 10); // small delay to allow transition to take effect
});

// Close the modal
closeModalButton.addEventListener('click', closeModal);

// Close modal when clicking outside the modal content
modal.addEventListener('click', (e) => {
    if (!modalContent.contains(e.target)) {
        closeModal();
    }
});

// Function to close the modal
function closeModal() {
    modalContent.classList.add('scale-', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300); // match the duration of the opacity transition
}
</script>
@endsection
