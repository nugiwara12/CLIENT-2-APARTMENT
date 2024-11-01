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
                        <h3 class="h5 font-semibold">Pending</h3>
                        <p class="text-2xl font-bold">0</p>
                        <button class="mt-2 text-blue-900 bg-yellow-200 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#pendingModal">
                            Show All Dates
                        </button>
                    </div>

                    <!-- Due Date Card -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Due Date</h3>
                        <p class="text-2xl font-bold">{{ $dueTodayCount }}</p>
                        <button class="mt-2 text-blue-900 bg-blue-200 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#dueModal">Show All Dates</button>
                    </div>

                    <!-- Past Due Card -->
                    <div class="bg-red-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Past Due</h3>
                        <p class="text-2xl font-bold">{{ $pastDueCount }}</p>
                        <button class="mt-2 text-blue-900 bg-red-200 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#pastDueModal">Show All Dates</button>
                    </div>

                    <!-- Paid Card -->
                    <div class="bg-green-100 p-4 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Total Payments</h3>
                        <p class="text-2xl font-bold">{{ $paymentCount }}</p> <!-- Ensure this is here -->
                        <button class="mt-2 text-blue-900 bg-green-300 py-2 px-4 rounded-lg show-all-dates" data-bs-toggle="modal" data-bs-target="#paidModal">Show All Dates</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Pending Dates -->
    <div class="modal fade" id="pendingModal" tabindex="-1" aria-labelledby="pendingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pendingModalLabel">All Pending Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Due Dates -->
    <div class="modal fade" id="dueModal" tabindex="-1" aria-labelledby="dueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dueModalLabel">All Due Dates</h5>
                    <p class="h4 mb-0">{{$dueTodayCount}}</p> <!-- Display the due today count -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($dueDates as $date)
                            <li>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Past Due Dates -->
    <div class="modal fade" id="pastDueModal" tabindex="-1" aria-labelledby="pastDueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pastDueModalLabel">All Past Due Dates</h5>
                    <p class="h4 mb-0">{{ $pastDueCount }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach($pastDueDates as $date)
                            <li>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Paid Modal for all dates -->
    <div class="modal fade" id="paidModal" tabindex="-1" aria-labelledby="paidModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paidModalLabel">All Paid Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($paymentDates as $date)
                            <li>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
</x-app-layout>
