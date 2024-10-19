<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-full mx-auto sm:px-3 lg:px-4">
            <x-room-booking.booking-card :eventCount="$eventCount" />
            <x-room-booking.apartment-booking />
        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function() {
    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initial rendering of calendar with events
    function initializeCalendar(events) {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },
            events: events, // Initial events
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                // Check if the selected start date is in the past
                if (moment(start).isBefore(moment(), 'day')) {
                    swal("Error!", "You cannot create events in the past!", "error");
                    return; // Prevent the modal from opening
                }

                // Open modal if the date is valid
                $('#bookingModal').modal('toggle');
                $('#saveBtn').off('click').on('click', function() {
                    var title = $('#title').val();
                    var start_date = moment(start).format('YYYY-MM-DD');
                    var end_date = moment(end).format('YYYY-MM-DD');

                    $.ajax({
                        url: "{{ route('booking.store') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            title,
                            start_date,
                            end_date
                        },
                        success: function(response) {
                            $('#bookingModal').modal('hide');
                            $('#calendar').fullCalendar('renderEvent', {
                                'id': response.id,
                                'title': response.title,
                                'start': response.start,
                                'end': response.end,
                                'color': response.color || '#3B82F6', // Default color if not set
                            });
                            swal("Success!", "Event created successfully!", "success");
                        },
                        error: function(error) {
                            if (error.responseJSON.errors) {
                                $('#titleError').html(error.responseJSON.errors.title);
                            }
                        },
                    });
                });
            },
            editable: true,
            eventRender: function(event, element) {
                element.css({
                    'background-color': event.color || '#3B82F6', // Custom color
                    'border-radius': '5px',
                    'padding': '5px',
                    'font-size': '12px',
                    'color': '#ffffff', // Font color
                });
                element.find('.fc-title').html(event.title);
            },
            eventDrop: function(event) {
                var id = event.id;
                var start_date = moment(event.start).format('YYYY-MM-DD');
                var end_date = moment(event.end).format('YYYY-MM-DD');

                $.ajax({
                    url: "{{ route('booking.update', ':id') }}".replace(':id', id),
                    type: "PATCH",
                    dataType: 'json',
                    data: {
                        start_date,
                        end_date
                    },
                    success: function(response) {
                        swal("Success!", "Event updated successfully!", "success");
                    },
                    error: function(error) {
                        swal("Error!", "Failed to update event!", "error");
                    },
                });
            },
            eventClick: function(event) {
                var id = event.id;

                swal({
                    title: "Are you sure?",
                    text: "Do you want to delete this event?",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: null,
                            visible: true,
                            className: "bg-gray-300 text-gray-700 px-4 py-2 rounded",
                        },
                        confirm: {
                            text: "Delete",
                            value: true,
                            visible: true,
                            className: "bg-red-500 text-white px-4 py-2 rounded",
                        },
                    },
                    dangerMode: true,
                    customClass: {
                        popup: 'swal-tailwind-popup', // Custom class for popup
                        title: 'text-lg font-bold', // Custom class for title
                        content: 'text-sm', // Custom class for content
                    },
                }).then((willDelete) => {
                    if (willDelete) {
                        // Perform the delete action
                        $.ajax({
                            url: "{{ route('booking.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            success: function(response) {
                                swal("Deleted!", "Your event has been deleted!", "success");
                                $('#calendar').fullCalendar('removeEvents', id);
                            },
                            error: function(error) {
                                swal("Error!", "Failed to delete event!", "error");
                            },
                        });
                    } else {
                        swal("Cancelled", "Your event is safe", "info");
                    }
                });
            },
            eventAfterRender: function(event, element) {
                // Set background color for dates to whitesmoke
                $('.fc-day').css('background-color', 'whitesmoke');
                // Make past dates dark gray
                $('.fc-day').each(function() {
                    var date = $(this).data('date');
                    if (moment(date).isBefore(moment(), 'day')) {
                        $(this).css('background-color', '#E5E7EB');
                    }
                });
                // Make day labels bold
                $('.fc-day-header').css('font-weight', 'bold');
            }
        });
    }

    // Fetch initial events and initialize calendar
    initializeCalendar(@json($events));

    setInterval(function() {
        $.ajax({
            url: "{{ route('booking') }}", 
            type: "GET",
            dataType: 'json',
            success: function(response) {
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', response.events); // Update events
            },
            error: function(error) {
                console.error("Error fetching events:", error);
            }
        });
    }, 10000); // Poll every 10 seconds

    // Handle modal close
    $("#bookingModal").on("hidden.bs.modal", function() {
        $('#saveBtn').off('click'); // Remove click event from save button
        $('#title').val(''); // Clear the title input
        $('#titleError').html(''); // Clear any error messages
    });

    // Customize FullCalendar event styling
    $('.fc-event').css({
        'font-size': '13px',
        'width': '20px',
        'border-radius': '50%'
    });
});
</script>
