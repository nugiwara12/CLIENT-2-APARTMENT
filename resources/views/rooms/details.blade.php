@extends('layouts.app2')

@section('contents')
<div class="container mt-5">
    <div class="card p-4 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-semibold mb-4">Room Details</h2>
        <ul class="list-unstyled">
            <li>Room Number: <span class="font-weight-bold">{{ $room->room_number }}</span></li>
            <li>Price: <span class="font-weight-bold">Php{{ number_format($room->price, 2) }}</span></li>
            <li>Description: <span class="font-weight-bold">{{ $room->description }}</span></li>
            <li>Availability: <span class="font-weight-bold">{{ $room->available ? 'Available' : 'Not Available' }}</span></li>
        </ul>
        <div class="main-button mt-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
        </div>
    </div>
</div>

<!-- Include the modal component -->
@include('components.room-booking.apartment-booking')

@endsection

