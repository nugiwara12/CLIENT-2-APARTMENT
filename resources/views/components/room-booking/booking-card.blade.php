<main class="p-6 sm:p-10 space-y-6">
    <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 uppercase">
        <div class="flex items-center p-8 bg-purple-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-200 rounded-full mr-6">
                <i class="bi bi-people-fill text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">62</span>
                <span class="block text-gray-500">Population</span>
            </div>
        </div>

        <!-- Male Section -->
        <div class="flex items-center p-8 bg-blue-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-200 rounded-full mr-6">
                <i class="bi bi-gender-male text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">3</span>
                <span class="block text-gray-500">Male</span>
            </div>
        </div>

        <!-- Female Section -->
        <div class="flex items-center p-8 bg-pink-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-pink-600 bg-pink-200 rounded-full mr-6">
                <i class="bi bi-gender-female text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">8</span>
                <span class="block text-black">Female</span>
            </div>
        </div>
        <!-- Voters Section -->
        <div class="flex items-center p-8 bg-yellow-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-yellow-600 bg-yellow-200 rounded-full mr-6">
                <i class="bi bi-fingerprint text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">6</span>
                <span class="block text-black">Voters</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-gray-200 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-gray-800 bg-gray-300 rounded-full mr-6">
                <i class="bi bi-person-dash text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">5</span>
                <span class="block text-black">Non Voters</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-green-100 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-200 rounded-full mr-6">
                <i class="bi bi-card-list text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">6</span>
                <span class="block text-black">Precinct</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-sky-300 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-sky-600 bg-sky-200 rounded-full mr-6">
                <i class="bi bi-signpost-2 text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">6</span>
                <span class="block text-black">Purok</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-red-400 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-red-600 bg-red-200 rounded-full mr-6">
                <i class="bi bi-card-list text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold">6</span>
                <span class="block text-black">Blotter</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-green-400 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-300 rounded-full mr-6">
                <i class="bi bi-currency-dollar text-2xl"></i>
            </div>
            <div>
                <span class="block text-2xl font-bold"><strong>₱:</strong> 6</span>
                <span class="block text-black">Revenue</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-red-500 shadow rounded-lg">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-red-600 bg-red-400 rounded-full mr-6">
                <i class="bi bi-calendar-event text-2xl"></i>
            </div>
            <div>
                <span class="block text-3xl font-bold">{{ $eventCount }}</span>
                <span class="block text-black">Sport Event</span>
            </div>
        </div>
    </section>
</main>