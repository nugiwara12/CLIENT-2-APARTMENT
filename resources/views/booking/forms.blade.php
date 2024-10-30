@extends('layouts.app2')

@section('contents')

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="breadcrumb">MABALACAT DORM: A WEB APPLICATION FOR ENHANCED TENANT MONITORING AND MANAGEMENT / APARTMENT</span>
                <h3>Booking Forms</h3>
                <p>Total Events: {{ $eventCount }}</p> <!-- Display total number of events -->
            </div>
        </div>
    </div>
</div>

<div class="section properties">
    <div class="container">
        <ul class="properties-filter">
            <li>
                <a class="is_active" href="#!" data-filter="*">APARTMENTS AVAILABLE</a>
            </li>
        </ul>
        <div class="row"> <!-- Row for horizontal alignment -->
            @foreach($rooms as $room)
                @if($room->available) <!-- Only show if the room is available -->
                <div class="col-md-4 mb-4"> <!-- Adjust column width for responsiveness -->
                    <div class="p-4 bg-white rounded-lg shadow-md border">
                        <ul class="list-unstyled">
                            <li>Room Number: <span class="font-weight-bold">{{ $room['room_number'] }}</span></li>
                            <li>Price: <span class="font-weight-bold">Php{{ number_format($room->price, 2) }}</span></li>
                            <li>Description: <span class="font-weight-bold">{{ $room->description }}</span></li>
                            <li>Availability: <span class="font-weight-bold">Available</span></li>
                        </ul>
                        <div class="main-button mt-4">
                            <!-- Inquire Button -->
                            <button class="bg-orange-600 text-white px-4 py-2 rounded-md" data-toggle="modal" data-target="#inquireModal">Inquire</button>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <!-- <ul class="properties-filter pt-10">
            <li>
                <a class="is_active" href="#!" data-filter="*">FOR SCHEDULES</a>
            </li>
        </ul>
        <div class="row properties-box">
            @foreach($events as $event) 
            <div class="col-lg-4 col-md-6 mb-30 properties-items">
                <div class="item border rounded-lg shadow-lg p-4 bg-white">
                    <a href="property-details.html" class="d-block mb-3">
                        
                    </a>
                    <span class="category badge badge-secondary">{{ $event['title'] }}</span>
                    <ul class="list-unstyled mt-3">
                        <li>Full Name: <span class="font-weight-bold">{{ $event['full_name'] }}</span></li>
                        <li>Contact Number: <span class="font-weight-bold">{{ $event['contact_number'] }}</span></li>
                        <li>Email: <span class="font-weight-bold">{{ $event['email'] }}</span></li>
                    </ul>
                    <div class="main-button mt-4">
                        <a href="property-details.html" class="btn btn-primary btn-block">Schedule a Visit</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="perPage">Show:</label>
            <select id="perPage" onchange="updatePerPage(this.value)">
                <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                <option value="18" {{ $perPage == 18 ? 'selected' : '' }}>18</option>
                <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
            </select>
        </div>

        <div class="pagination">
            {{ $events->appends(['perPage' => $perPage])->links() }}
        </div> -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="inquireModal" tabindex="-1" aria-labelledby="inquireModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content bg-white rounded-lg shadow-lg">
            <div class="modal-header border-b p-4 flex items-center justify-between">
                <h5 class="modal-title text-lg font-semibold" id="inquireModalLabel">Apartment Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 grid grid-cols-1 gap-4">
                <!-- Static Apartment Data -->
                <div id="apartmentDetails" class="bg-gray-100 p-4 rounded-md mb-4">
                    <h6 class="text-md font-semibold">Apartment Details</h6>
                    <div id="roomImagesCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if($room->apartment_image)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $room->apartment_image) }}" alt="Apartment Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                </div>
                            @endif
                            @if($room->bathroom_image)
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/' . $room->bathroom_image) }}" alt="Bathroom Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                </div>
                            @endif
                            @if($room->outside_image)
                                <div class="carousel-item">
                                    <img src="{{ asset('storage/' . $room->outside_image) }}" alt="Outside Image" class="d-block w-100" style="height: 300px; object-fit: contain;">
                                </div>
                            @endif
                        </div>

                        <!-- Carousel controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="">
                        <ul class="list-unstyled">
                            <li>Room Number: <span class="font-bold">{{ $room->room_number }}</span></li>
                            <li>Price: <span class="font-bold">Php{{ number_format($room->price, 2) }}</span></li>
                            <li>Description: <span class="font-bold">{{ $room->description }}</span></li>
                            <li>Availability: <span class="font-bold">{{ $room->available ? 'Available' : 'Not Available' }}</span></li>
                        </ul>
                    </div>
                </div>

                <!-- User Inquiry Form -->
                <div id="inquiryForm" class="hidden">
                    <div>
                        <label class="text-sm font-semibold mb-2" for="title">Title</label>
                        <input type="text" id="title" class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter event title">
                        <span id="titleError" class="text-red-500 mt-1 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-2" for="full_name">Full Name</label>
                        <input type="text" id="full_name" class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your full name">
                        <span id="fullNameError" class="text-red-500 mt-1 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-2" for="contact_number">Contact Number</label>
                        <input type="text" id="contact_number" class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your contact number">
                        <span id="contactNumberError" class="text-red-500 mt-1 text-sm"></span>
                    </div>

                    <div>
                        <label class="text-sm font-semibold mb-2" for="email">Email Address</label>
                        <input type="email" id="email" class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" placeholder="Enter your email address">
                        <span id="emailError" class="text-red-500 mt-1 text-sm"></span>
                    </div>

                    <!-- Valid ID Upload Field -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="text-sm font-semibold mb-2" for="">Valid Id</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file-validId" class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                                <div id="validId" class="flex flex-col items-center justify-center">
                                    <svg class="w-5 h-5 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 md:text-center sm:text-center lg:text-center">JPG, PNG, GIF, or WEBP (MAX. 800x400px)</p>
                                </div>
                                <input id="dropzone-file-validId" name="valid_id" type="file" class="hidden" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewImage(event, 'valid-id')" />
                                <img id="valid-id" class="hidden w-full h-full object-contain" alt="Image Preview" />
                            </label>
                        </div>
                        <span id="validIdError" class="text-red-500 mt-1 text-sm"></span>
                    </div>
                    <div class="max-w-full mx-auto whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="agreementCheckbox" class="mr-1">
                            <label for="agreementCheckbox" class="text-sm mt-2">I agree to the terms and conditions</label>
                        </div>
                        <!-- Agreement Modal -->
                        <div id="agreementModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-lg">
                                <h3 class="text-lg font-semibold mb-4">Terms and Conditions</h3>
                                <p class="mb-4 text-center">Please read and agree to the following terms and <br> conditions before proceeding with your booking:</p>
                                <ul class="list-disc list-inside mb-4">
                                    <li>All bookings are subject to availability.</li>
                                    <li>Cancellation policies may apply based on the selected apartment.</li>
                                    <li>Guests must adhere to house rules and regulations.</li>
                                    <li>Damage to property may result in additional charges.</li>
                                    <li>Check-in and check-out times must be respected.</li>
                                </ul>
                                <div class="mt-4 flex justify-end">
                                    <button id="confirmAgreement" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">I Agree</button>
                                    <button id="closeModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 ml-2" onclick="document.getElementById('agreementModal').classList.add('hidden')">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-t p-4 flex justify-between">
                <button type="button" id="backBtn" class="bg-gray-300 text-gray-700 rounded-md px-4 py-2 hover:bg-gray-400 hidden" onclick="showApartmentDetails()">Back</button>
                <button type="button" id="nextBtn" class="bg-orange-600 text-white rounded-md px-4 py-2 hover:bg-orange-700" onclick="showInquiryForm()">Next</button>
                <button type="button" id="submitBtn" class="bg-orange-600 text-white rounded-md px-4 py-2 hover:bg-orange-700 hidden">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function updatePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('perPage', value);
    window.location = url; // Redirect to the same page with the new perPage value
}

document.getElementById('agreementCheckbox').addEventListener('change', function() {
    var agreementModal = document.getElementById('agreementModal');
    if (this.checked) {
        agreementModal.classList.remove('hidden'); // Show the modal
    } else {
        agreementModal.classList.add('hidden'); // Hide the modal if unchecked
    }
});

// Close modal when clicking the close button
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('agreementModal').classList.add('hidden');
    document.getElementById('agreementCheckbox').checked = false; // Uncheck the checkbox
});

// Confirm agreement action
document.getElementById('confirmAgreement').addEventListener('click', function() {
    // Use SweetAlert to show a thank you message
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Thank You So Much!',
        confirmButtonText: 'Continue'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('agreementModal').classList.add('hidden');
            document.getElementById('agreementCheckbox').checked = true; // Keep checkbox checked
        }
    });
});

// Image preview with validation
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const validIdError = document.getElementById('validIdError');

    const sampleImageDivs = {
        'valid-id': 'validId',
    };

    if (file) {
        // Check file type
        if (!validImageTypes.includes(file.type)) {
            validIdError.textContent = 'Invalid file type. Please upload JPG, PNG, GIF, or WEBP.';
            event.target.value = ''; // Clear the input
            preview.classList.add('hidden'); // Hide the preview image
            return; // Exit the function
        } else {
            // Clear the error message
            validIdError.textContent = '';
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result; // Set the image source
            preview.classList.remove('hidden'); // Show the image

            // Hide the corresponding sample image div
            if (sampleImageDivs[previewId]) {
                document.getElementById(sampleImageDivs[previewId]).classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden'); // Hide the preview if no file is selected
        validIdError.textContent = ''; // Clear error message
    }
}

function showInquiryForm() {
    document.getElementById('apartmentDetails').classList.add('hidden');
    document.getElementById('inquiryForm').classList.remove('hidden');
    document.getElementById('nextBtn').classList.add('hidden');
    document.getElementById('submitBtn').classList.remove('hidden');
    document.getElementById('backBtn').classList.remove('hidden');
}

function showApartmentDetails() {
    document.getElementById('inquiryForm').classList.add('hidden');
    document.getElementById('apartmentDetails').classList.remove('hidden');
    document.getElementById('nextBtn').classList.remove('hidden');
    document.getElementById('submitBtn').classList.add('hidden');
    document.getElementById('backBtn').classList.add('hidden');
}

function resetModal() {
    // Clear input fields
    document.getElementById('title').value = '';
    document.getElementById('full_name').value = '';
    document.getElementById('contact_number').value = '';
    document.getElementById('email').value = '';
    document.getElementById('valid-id').classList.add('hidden');

    // Clear error messages
    document.getElementById('titleError').textContent = '';
    document.getElementById('fullNameError').textContent = '';
    document.getElementById('contactNumberError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('validIdError').textContent = '';

    // Show apartment details and hide inquiry form
    showApartmentDetails();
}

// Event listener to reset modal on hide
$('#inquireModal').on('hidden.bs.modal', function () {
    resetModal(); // Call the reset function when the modal is closed
});
</script>
@endsection
