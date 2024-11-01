<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Logged in Message -->
                <div id="login-message" class="mt-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Pending Card -->
                    <div class="bg-yellow-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Pending</h3>
                        <p class="text-2xl font-bold">0</p>
                        <button class="mt-2 text-blue-600 toggle-dates" data-target="pendingDates">Show Dates</button>
                        <button class="mt-2 text-blue-600 show-all-dates" data-target="#pendingModal">Show All Dates</button>
                        <ul id="pendingDates" class="mt-2 hidden">
                            <li>2024-10-01</li>
                            <li>2024-10-05</li>
                            <li>2024-10-10</li>
                        </ul>
                    </div>

                    <!-- Due Date Card -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Due Date</h3>
                        <p class="text-2xl font-bold">{{ $dueTodayCount }}</p>
                        <button class="mt-2 text-blue-600 toggle-dates" data-target="dueDate">Show Dates</button>
                        <button class="mt-2 text-blue-600 show-all-dates" data-target="#dueModal">Show All Dates</button>
                        <ul id="dueDate" class="mt-2 hidden">
                            @foreach ($dueDates as $date)
                                <li>{{ $date }}</li>
                            @endforeach
                        </ul>
                    </div>


                    <!-- Past Due Card -->
                    <div class="bg-red-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Past Due</h3>
                        <!-- Display the actual past due count from $pastDueCount -->
                        <p class="text-2xl font-bold">{{ $pastDueCount }}</p>
                        
                        <!-- Toggle to show past due dates -->
                        <button class="mt-2 text-blue-600 toggle-dates" data-target="pastDue">Show Dates</button>
                        <button class="mt-2 text-blue-600 show-all-dates" data-target="#pastDueModal">Show All Dates</button>
                        
                        <!-- List past due dates -->
                        <ul id="pastDue" class="mt-2 hidden">
                            @foreach($pastDueDates as $date)
                                <li>{{ $date }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Paid Card -->
                    <div class="bg-green-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Total Payments</h3>
                        <p class="text-2xl font-bold">{{ $paymentCount }}</p> <!-- Ensure this is here -->
                        
                        <button class="mt-2 text-blue-600 toggle-dates" data-target="paidDates">Show Dates</button>
                        <button class="mt-2 text-blue-600 show-all-dates" data-target="#paidModal">Show All Dates</button>
                        
                        <ul id="paidDates" class="mt-2 hidden">
                            @foreach ($paymentDates as $date)
                                <li>{{ $date }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for all dates -->
    <div class="modal" id="pendingModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Pending Dates</h5>
                    <button type="button" class="close-button" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>2024-10-01</li>
                        <li>2024-10-05</li>
                        <li>2024-10-10</li>
                        <li>2024-10-15</li>
                        <li>2024-10-20</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close-button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="dueModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Due Dates</h5>
                    <p class="text-2xl font-bold">{{$dueTodayCount}}</p>
                    <button type="button" class="close-button" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($dueDates as $date)
                            <li>{{ $date }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close-button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="pastDueModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Past Due Dates</h5>
                    <p class="text-2xl font-bold">{{$pastDueCount}}</p>
                    <button type="button" class="close-button" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($pastDueDates as $date)
                            <li>{{ $date }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close-button">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Paid Modal for all dates -->
    <div class="modal" id="paidModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Paid Dates</h5>
                    <button type="button" class="close-button" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($paymentDates as $date)
                            <li>{{ $date }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close-button">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 pb-10 pt-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full mx-auto" style="max-width: 1200px">
            <!-- First Form for Gcash -->
            <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full pt-1 pb-5">
                        <div class="bg-indigo-500 text-white overflow-hidden rounded-full w-20 h-20 -mt-20 mx-auto shadow-lg flex justify-center items-center">
                            <i class="bi bi-shield-lock fs-1"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-center font-bold text-xl uppercase">Secure payment info</h1>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <label for="gcash" class="flex items-center cursor-pointer mb-2">
                            <img src="{{ asset('assets/images/qr-code.png') }}" alt="GCash Logo" class="h-40">
                        </label>
                        <label for="gcash_number" class="text-center">095654245165</label>
                    </div>
                    
                    <!-- Due Date Dropdown -->
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                        <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                            <option disabled>Select one or more due dates</option>
                            
                            <!-- Current Due Dates -->
                            @foreach($dueDates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                            
                            <!-- Optional Divider for Past Due Dates -->
                            <option disabled>────── Past Due Dates ──────</option>
                            
                            <!-- Past Due Dates -->
                            @foreach($pastDueDates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Full Name</label>
                        <div>
                            <input name="full_name" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Full Name" type="text" required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Phone Number (Gcash Registered)</label>
                        <div>
                            <input name="phone_number" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Phone Number" type="text" required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Payment Method</label>
                        <div>
                            <input name="payment_method" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" type="text" value="GCASH" readonly/>
                        </div>
                    </div>
                    <div class="mb-10">
                        <label class="font-bold text-sm mb-2 ml-1">Upload QR Code</label>
                        <div>
                            <input name="qr_code" type="file" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" required />
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">
                            <i class="mdi mdi-lock-outline mr-1"></i> PAY NOW
                        </button>
                    </div>
                </form>
            </div>

            <!-- Second Form for Maya -->
            <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full pt-1 pb-5">
                        <div class="bg-indigo-500 text-white overflow-hidden rounded-full w-20 h-20 -mt-20 mx-auto shadow-lg flex justify-center items-center">
                            <i class="bi bi-shield-lock fs-1"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-center font-bold text-xl uppercase">Secure payment info</h1>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <label for="maya" class="flex items-center cursor-pointer mb-2">
                            <img src="{{ asset('assets/images/qr-code.png') }}" alt="Maya Logo" class="h-40">
                        </label>
                        <label for="maya_number" class="text-center">095654245165</label>
                    </div>               
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Select Due Date</label>
                        <select name="due_date[]" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" multiple required size="5">
                            <option disabled>Select one or more due dates</option>
                            
                            <!-- Current Due Dates -->
                            @foreach($dueDates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                            
                            <!-- Optional Divider for Past Due Dates -->
                            <option disabled>────── Past Due Dates ──────</option>
                            
                            <!-- Past Due Dates -->
                            @foreach($pastDueDates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Full Name</label>
                        <div>
                            <input name="full_name" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Full Name" type="text" required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Phone Number (Maya Registered)</label>
                        <div>
                            <input name="phone_number" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Enter your Phone Number" type="text" required/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Payment Method</label>
                        <div>
                            <input name="payment_method" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" type="text" value="Maya" readonly/>
                        </div>
                    </div>
                    <div class="mb-10">
                        <label class="font-bold text-sm mb-2 ml-1">Upload QR Code</label>
                        <div>
                            <input name="qr_code" type="file" class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" required />
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold">
                            <i class="mdi mdi-lock-outline mr-1"></i> PAY NOW
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- Add this script to handle the message visibility and toggle dropdowns -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var message = document.getElementById('login-message');
            setTimeout(function () {
                message.style.display = 'none';
            }, 5000);

            // Toggle date list visibility
            const toggleButtons = document.querySelectorAll('.toggle-dates');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetList = document.getElementById(targetId);
                    targetList.classList.toggle('hidden'); // Toggle the hidden class
                });
            });

            // Show modal when clicking on "Show All Dates"
            const showAllDateButtons = document.querySelectorAll('.show-all-dates');
            showAllDateButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modalId = this.getAttribute('data-target');
                    const modal = document.querySelector(modalId);
                    modal.style.display = 'block'; // Show modal
                });
            });

            // Close modal functionality
            const closeButtons = document.querySelectorAll('.close-button');
            closeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const modal = this.closest('.modal');
                    modal.style.display = 'none'; // Hide modal
                });
            });

            // Close modal when clicking outside the modal content
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        modal.style.display = 'none'; // Hide modal
                    }
                });
            });
        });
    </script>
</x-app-layout>
