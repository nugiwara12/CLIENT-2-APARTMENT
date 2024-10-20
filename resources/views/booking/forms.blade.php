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
                <a class="is_active" href="#!" data-filter="*">APARTMENT</a>
            </li>
        </ul>

        <div class="row properties-box">
            @foreach($events as $event) <!-- Loop through events -->
            <div class="col-lg-4 col-md-6 mb-30 properties-items">
                <div class="item border rounded-lg shadow-lg p-4 bg-white">
                    <a href="property-details.html" class="d-block mb-3">
                        <!-- Image -->
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

        <!-- Show entries selection -->
        <div class="mb-3">
            <label for="perPage">Show:</label>
            <select id="perPage" onchange="updatePerPage(this.value)">
                <option value="6" {{ $perPage == 6 ? 'selected' : '' }}>6</option>
                <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>12</option>
                <option value="18" {{ $perPage == 18 ? 'selected' : '' }}>18</option>
                <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>24</option>
            </select>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            {{ $events->appends(['perPage' => $perPage])->links() }}
        </div>
    </div>
</div>

<script>
function updatePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('perPage', value);
    window.location = url; // Redirect to the same page with the new perPage value
}
</script>

@endsection
