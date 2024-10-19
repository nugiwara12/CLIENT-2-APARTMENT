<div class="max-w-full mx-auto p-6">
    <div class="text-center mb-4">
        <h1 class="text-2xl font-bold">Event Calendar</h1>
    </div>
    <div id="calendar"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content bg-white rounded-lg shadow-lg">
            <div class="modal-header border-b p-4 flex items-center justify-between">
                <h5 class="modal-title text-lg font-semibold" id="exampleModalLabel">Booking Title</h5>
                <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none" data-bs-dismiss="modal" aria-label="Close">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body p-4 grid grid-cols-1 md:grid-cols-2 gap-4">
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

                <div class="col-span-2">
                    <label class="flex items-center mt-4">
                        <input type="checkbox" id="condition_agreement" class="mr-2">
                        <span class="text-sm">I agree to the terms and conditions</span>
                    </label>
                    <span id="agreementError" class="text-red-500"></span>
                </div>

                <!-- Valid ID Upload Field -->
                <div class="col-span-1 md:col-span-2">
                    <label for="">Valid Id</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file-validId" class="flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
                            <div id="validId" class="flex flex-col items-center justify-center">
                                <svg class="w-5 h-5 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 md:text-center sm:text-center lg:text-center">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="dropzone-file-validId" name="valid_id" type="file" class="hidden" onchange="previewImage(event, 'valid-id')" />
                            <img id="valid-id" class="hidden w-full h-full object-contain" alt="Image Preview" />
                        </label>
                    </div>
                    <span id="validIdError" class="text-red-500 mt-1 text-sm"></span>
                </div>
            </div>
            <div class="modal-footer border-t p-4 flex justify-end">
                <button type="button" id="saveBtn" class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);

    const sampleImageDivs = {
        'valid-id': 'validId',
    };

    if (file) {
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
        preview.classList.add('hidden');
    }
}
</script>
