<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Contacts List</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto flex justify-center">
            <table class="min-w-full bg-white shadow-md rounded-lg text-center">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Phone Number</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 border-b border-gray-300 text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->full_name }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->email }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->phone_number }}</td>
                            <td class="px-6 py-4 border-b border-gray-300">{{ $contact->message }}</td>
                            <td class="px-6 py-4 border-b border-gray-300 flex space-x-2 justify-center items-center">
                                <!-- Button to Open Modal -->
                                <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none"
                                        data-bs-toggle="modal" data-bs-target="#editContactModal{{ $contact->id }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('contact.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none" title="Delete"><i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editContactModal{{ $contact->id }}" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('contact.update', $contact->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="full_name" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $contact->full_name }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $contact->phone_number }}" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="message" class="form-label">Message</label>
                                                <textarea class="form-control" id="message" name="message" rows="4" required>{{ $contact->message }}</textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success w-100 mt-3">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Edit Modal -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
