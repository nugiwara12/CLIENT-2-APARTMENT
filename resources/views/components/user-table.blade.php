
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
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-200"> <!-- Added stripe effect -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-black">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->role }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-black text-left">
                            <div class="dropdown">
                                <button class="text-black" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots text-black text-lg"></i>
                                </button>
                                <div class="dropdown-menu absolute left-0 w-10 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20">
                                    <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-black hover:text-blue-600 no-italic" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>
                                    <!-- Delete Form -->
                                    <form id="deleteForm{{ $user->id }}" action="{{ route('usermanagement.destroy', $user->id) }}" method="POST" class="block delete-form" role="menuitem">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="block px-4 py-2 text-sm text-black hover:text-blue-600" onclick="confirmDelete('{{ $user->id }}')">
                                            <i class="bi bi-trash"></i> 
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($users as $user)
    @include('components.modal.usermanagement.edit-user', ['user' => $user])
@endforeach



