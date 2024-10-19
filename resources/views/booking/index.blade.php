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

@section('scripts')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function initializeCalendar(events) {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },
            events: events,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
                if (moment(start).isBefore(moment(), 'day')) {
                    Swal.fire("Error!", "You cannot create events in the past!", "error");
                    return;
                }

                $('#bookingModal').modal('toggle');
                clearModalFields(); // Clear fields but not error messages

                $('#saveBtn').off('click').on('click', function() {
                    var title = $('#title').val();
                    var full_name = $('#full_name').val();
                    var contact_number = $('#contact_number').val();
                    var email = $('#email').val();
                    var valid_id = $('#dropzone-file-validId')[0].files[0];
                    var condition_agreement = $('#condition_agreement').is(':checked') ? 1 : 0; // Send as integer
                    var start_date = moment(start).format('YYYY-MM-DD HH:mm:ss');
                    var end_date = moment(end).format('YYYY-MM-DD HH:mm:ss');

                    // Clear previous errors
                    clearModalErrors();

                    if (condition_agreement === 0) {
                        $('#agreementError').html('You must agree to the terms and conditions.');
                    }

                    // Validate all required fields
                    let hasErrors = false;
                    if (!title) {
                        $('#titleError').html('Title is required.');
                        hasErrors = true;
                    }
                    if (!full_name) {
                        $('#fullNameError').html('Full Name is required.');
                        hasErrors = true;
                    }
                    if (!contact_number) {
                        $('#contactNumberError').html('Contact Number is required.');
                        hasErrors = true;
                    }
                    if (!email) {
                        $('#emailError').html('Email is required.');
                        hasErrors = true;
                    }
                    if (!valid_id) {
                        $('#validIdError').html('Valid ID is required.');
                        hasErrors = true;
                    }
                    if (hasErrors || condition_agreement === 0) {
                        return; // Exit if there are errors
                    }

                    var formData = new FormData();
                    formData.append('title', title);
                    formData.append('full_name', full_name);
                    formData.append('contact_number', contact_number);
                    formData.append('email', email);
                    formData.append('valid_id', valid_id);
                    formData.append('condition_agreement', condition_agreement);
                    formData.append('start_date', start_date);
                    formData.append('end_date', end_date);

                    $.ajax({
                        url: "{{ route('booking.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#bookingModal').modal('hide');
                            $('#calendar').fullCalendar('renderEvent', {
                                'id': response.id,
                                'title': `${response.title} (${response.full_name}, ${response.email})`,
                                'start': response.start,
                                'end': response.end,
                                'color': response.color || '#3B82F6',
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Event created successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Reload the page after success
                            });
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors || {};
                            clearModalErrors(); // Clear previous errors

                            let errorMessages = 'Email already exists.\n';
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessages += `${errors[key].join(', ')}\n`;
                                    $(`#${key}Error`).html(errors[key].join(', ')); // Display each field's error
                                }
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error!',
                                text: errorMessages.trim(),
                                confirmButtonText: 'OK'
                            });
                        },
                    });
                });
            },
            editable: true,
            eventResize: function(event) {
                $.ajax({
                    url: `{{ url('booking') }}/${event.id}`,
                    type: "PATCH",
                    data: {
                        start_date: event.start.format(),
                        end_date: event.end.format(),
                    },
                    success: function(response) {
                        Swal.fire("Success!", "Event updated successfully!", "success").then(() => {
                            location.reload(); // Reload the page after update
                        });
                    },
                    error: function(error) {
                        Swal.fire("Error!", "Unable to update the event.", "error").then(() => {
                            location.reload(); // Reload the page after error
                        });
                    },
                });
            },
            eventDrop: function(event) {
                $.ajax({
                    url: `{{ url('booking') }}/${event.id}`,
                    type: "PATCH",
                    data: {
                        start_date: event.start.format(),
                        end_date: event.end.format(),
                    },
                    success: function(response) {
                        Swal.fire("Success!", "Event updated successfully!", "success").then(() => {
                            location.reload(); // Reload the page after update
                        });
                    },
                    error: function(error) {
                        Swal.fire("Error!", "Unable to update the event.", "error").then(() => {
                            location.reload(); // Reload the page after error
                        });
                    },
                });
            },
            eventClick: function(event) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('booking.destroy', '') }}/${event.id}`,
                            type: "DELETE",
                            success: function(response) {
                                // Update UI to reflect the status change
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                Swal.fire(
                                    'Deleted!',
                                    'Event deleted successfully!',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Reload the page after delete
                                });
                            },
                            error: function(error) {
                                Swal.fire(
                                    'Error!',
                                    'Unable to delete the event.',
                                    'error'
                                ).then(() => {
                                    location.reload(); // Reload the page after error
                                });
                            },
                        });
                    }
                });
            }
        });

        $('#bookingModal').on('hidden.bs.modal', function () {
            clearModalFields(); // Clear fields
            clearModalErrors(); // Clear errors
        });
    }

    function clearModalFields() {
        $('#title').val('');
        $('#full_name').val('');
        $('#contact_number').val('');
        $('#email').val('');
        $('#dropzone-file-validId').val(''); // Clear the file input
        $('#condition_agreement').prop('checked', false); // Uncheck the agreement checkbox
    }

    function clearModalErrors() {
        $('#agreementError').html(''); // Clear any agreement error message
        $('#titleError').html('');
        $('#fullNameError').html('');
        $('#contactNumberError').html('');
        $('#emailError').html('');
        $('#validIdError').html('');
    }

    initializeCalendar(@json($events));
});
</script>
@ensection