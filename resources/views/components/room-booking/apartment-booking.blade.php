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
                <button type="button" class="text-gray-500 hover:text-gray-700 focus:outline-none"
                    data-bs-dismiss="modal" aria-label="Close">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="modal-body p-4">
                <label class="text-sm font-semibold mb-2" for="title">Title</label>
                <input type="text" id="title"
                    class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                    placeholder="Enter event title">
                <span id="titleError" class="text-red-500 mt-1 text-sm"></span>
            </div>
            <div class="modal-footer border-t p-4 flex justify-end">
                <button type="button" id="saveBtn"
                    class="bg-blue-600 text-white rounded-md px-4 py-2 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">Save</button>
            </div>
        </div>
    </div>
</div>