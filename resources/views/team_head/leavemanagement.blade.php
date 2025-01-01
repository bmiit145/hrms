@extends('team_head.team_head_layout.sidebar')
@section('content')
    <style>
        div.dataTables_wrapper {
            position: relative;
            padding: 1.5%;
        }

        .light-style table.table-bordered.dataTable th,
        .light-style table.table-bordered.dataTable td {
            border-color: #E6E59C !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0px solid #e6e5e8;
        }

        body.dark-mode table.dataTable.no-footer {
            border-bottom: 0px solid #474360;
        }

        label.error {
            display: block;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        table#example th.sorting {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">Employee Leave Request</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button class="btn create-new waves-effect waves-light employee" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button">
                                    <span class="text-white">
                                        <i class="ri-add-line"></i>
                                        <span class="d-none d-sm-inline-block">Add New Leave</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                        aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select_all">
                                </th>
                                <th>Sr No.</th>
                                <th>Apply Date</th>
                                <th>Leave Type</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Reason</th>
                                <th>Admin Status </th>
                                <th>Admin Rejecte Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select_row" data-id="{{ $item->id }}">
                                    </td>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td style="overflow-x: auto;white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                    <td class="leaveType" style="overflow-x: auto;white-space: nowrap;">
                                        {{ $item->leaveType->leave_type ?? 'N/A' }}</td>

                                    <td class="fromDate" style="overflow-x: auto;white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') }}</td>
                                    <td class="toDate" style="overflow-x: auto;white-space: nowrap;">
                                        @if ($item->to_date != null)
                                            {{ \Carbon\Carbon::parse($item->to_date)->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="details-display">
                                            <!-- Initially show the first 20 characters of details -->
                                            <span class="details-short">{{ \Str::limit($item->leave_reason, 20) }}</span>

                                            <!-- Show "Show More" link if details are longer than 20 characters -->
                                            @if (strlen($item->leave_reason) > 20)
                                                <span class="details-more">
                                                    <a href="javascript:void(0)" class="show-more">Show More</a>
                                                </span>
                                            @endif

                                            <!-- Full details that will be shown when "Show More" is clicked -->
                                            <span class="details-full"
                                                style="display: none;">{{ $item->leave_reason }}</span>

                                            <!-- Show Less link -->
                                            <span class="show-less" style="display: none;">
                                                <a href="javascript:void(0)" class="show-less">Show Less</a>
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        @if ($item->status == null)
                                            <div></div>
                                        @elseif($item->status == 0)
                                            <div style="color: red">Rejected</div>
                                        @elseif($item->status == 1)
                                            <div style="color: green">Approved</div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="details-display">
                                            <!-- Initially show the first 20 characters of details -->
                                            <span class="details-short">{{ \Str::limit($item->rejected_reason, 20) }}</span>

                                            <!-- Show "Show More" link if details are longer than 20 characters -->
                                            @if (strlen($item->rejected_reason) > 20)
                                                <span class="details-more">
                                                    <a href="javascript:void(0)" class="show-more">Show More</a>
                                                </span>
                                            @endif

                                            <!-- Full details that will be shown when "Show More" is clicked -->
                                            <span class="details-full"
                                                style="display: none;">{{ $item->rejected_reason }}</span>

                                            <!-- Show Less link -->
                                            <span class="show-less" style="display: none;">
                                                <a href="javascript:void(0)" class="show-less">Show Less</a>
                                            </span>
                                        </span>
                                    </td>
                                    <td>
                                        <a class="edit" href="#" data-id='{{ $item->id }}'
                                            data-leave='{{ $item->leave_type }}' data-from_date='{{ $item->from_date }}'
                                            data-to_date='{{ $item->to_date }}'
                                            data-leave_reason='{{ $item->leave_reason }}'>
                                            <i class="ri-edit-box-line list-btn" style="font-size:24px;"></i>
                                        </a>
                                        <a href="#" class="delete" data-id='{{ $item->id }}'>
                                            <i class="ri-delete-bin-6-line list-btn" style="font-size:24px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button class="dt-button buttons-delete btn btn-danger buttons-html5 btn-delete" tabindex="0"
                        aria-controls="example" type="button" style="display:none !important;" id="delete_button">
                        <i class="ri-delete-bin-7-line ri-22px"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="offcanvas offcanvas-end" id="add-new-record" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="myModalLabel">New Add Leave Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="addForm" class="leaveAdd" enctype="multipart/form-data">
                @csrf
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <select class="form-control add_leave_type" name="leave_type" id="add_leave_type">
                                <option value="">Select Leave Type</option>
                                @foreach ($leave as $item)
                                    <option value="{{ $item->id }}">{{ $item->leave_type }}</option>
                                @endforeach
                            </select>
                            <label for="add_leave_type">Leave Type</label>
                        </div>
                    </div>
                    <label id="add_leave_type-error" class="error" for="add_leave_type"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control dob-picker" name="from_date"
                                id="add_from_date" placeholder="">
                            <label for="add_from_date">From Date</label>
                        </div>
                    </div>
                    <label id="add_from_date-error" class="error" for="add_from_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control dob-picker" name="to_date"
                                id="add_to_date" placeholder="">
                            <label for="add_to_date">To Date</label>
                        </div>
                    </div>
                    <label id="add_to_date-error" class="error" for="add_to_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="add_leave_reason" class="input-group-text"><i
                                class="ri-sticky-note-add-line"></i></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" class="form-control leave_reason" name="leave_reason" row="15" cols="50"
                                id="add_leave_reason" placeholder="Enter Employee Reason" aria-label="Enter Date"
                                aria-describedby="basicFullname2"></textarea>
                            <label for="add_leave_reason">Reason</label>
                        </div>
                    </div>
                    <label id="add_leave_reason-error" class="error" for="add_leave_reason"></label>
                </div>
                <button type="submit" class="btn mt-3 waves-effect"
                    style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Create</button>
                <button type="reset" class="btn mt-3 btn-outline-secondary waves-effect"
                    data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="offcanvas offcanvas-end" id="edit-new-record" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="myModalLabel">Edit Leave Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form id="editForm" method="POST" enctype="multipart/form-data" class="leaveEdit">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <select class="form-control add_leave_type" name="leave_type" id="edit_leave_type">
                                <option value="">Select Leave Type</option>
                                @foreach ($leave as $item)
                                    <option value="{{ $item->id }}">{{ $item->leave_type }}</option>
                                @endforeach
                            </select>
                            <label for="edit_leave_type">Leave Type</label>
                        </div>
                    </div>
                    <label id="edit_leave_type-error" class="error" for="edit_leave_type"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control dob-picker" name="from_date"
                                id="edit_from_date" placeholder="">
                            <label for="basicFullname">From Date</label>
                        </div>
                    </div>
                    <label id="edit_from_date-error" class="error" for="edit_from_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control dob-picker" name="to_date"
                                id="edit_to_date" placeholder="">
                            <label for="basicFullname">To Date</label>
                        </div>
                    </div>
                    <label id="edit_to_date-error" class="error" for="edit_to_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-sticky-note-add-line"></i></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" class="form-control leave_reason" name="leave_reason" id="edit_leave_reason"
                                placeholder="Enter Employee Reason"></textarea>
                            <label for="edit_leave_reason">Reason</label>
                        </div>
                    </div>
                    <label id="edit_leave_reason-error" class="error" for="edit_leave_reason"></label>
                </div>
                <button type="submit" class="btn mt-3"
                    style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;">Update</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Offcanvas) -->
    <div class="offcanvas offcanvas-end" id="delete-new-record" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Records</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <h5 class="text-center">Are you sure you want to delete the selected records?</h5>
            <form action="{{ route('teamHead.teamHead_delete_leave_request') }}" method="POST" id="delete-form">
                @csrf
                <input type="hidden" name="ids" id="delete-id">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-danger waves-effect waves-light">
                        Delete
                    </button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="offcanvas">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open Add New Record Offcanvas
            const openAddButton = document.querySelector('.create-new');
            const offcanvasAdd = new bootstrap.Offcanvas(document.getElementById('add-new-record'));

            openAddButton.addEventListener('click', function() {
                offcanvasAdd.show();
            });

            // Open Edit Record Offcanvas
            $(document).on('click', '.edit', function(event) {
                event.preventDefault();

                // Fetch data from the edit button
                const id = $(this).data('id');
                const leave_type = $(this).data('leave');
                const from_date = $(this).data('from_date');
                const to_date = $(this).data('to_date');
                const leave_reason = $(this).data('leave_reason');

                // Show the edit modal
                const editModal = new bootstrap.Offcanvas(document.getElementById('edit-new-record'));
                editModal.show();

                // Populate the form fields
                $('#edit_id').val(id);
                $('#edit_leave_type').val(leave_type);
                $('#edit_from_date').val(from_date);
                $('#edit_to_date').val(to_date);
                $('#edit_leave_reason').val(leave_reason);
            });

            // Form validation for leave creation
            $('.leaveAdd').validate({
                rules: {
                    leave_type: {
                        required: true,
                    },
                    from_date: {
                        required: true,
                    },
                    to_date: {
                        required: true,
                    },
                    leave_reason: {
                        required: true,
                    },
                },
                messages: {
                    leave_type: {
                        required: "Leave type is required",
                    },
                    from_date: {
                        required: "From date is required",
                    },
                    to_date: {
                        required: "To date is required",
                    },
                    leave_reason: {
                        required: "Reason is required",
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('add_leave_type') || element.hasClass(
                            'leave_reason')) {
                        error.insertAfter(
                            element);
                    } else {
                        error.insertAfter(
                            element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    if (!$(element).hasClass('add_leave_type') && !$(element)
                        .hasClass('leave_reason')) {
                        $(element).addClass(errorClass).removeClass(validClass);
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    if (!$(element).hasClass('add_leave_type') && !$(element)
                        .hasClass('leave_reason')) {
                        $(element).removeClass(errorClass).addClass(validClass);
                    }
                },
                submitHandler: function(form) {
                    const formData = new FormData(form);
                    const submitButton = $(form).find('button[type="submit"]');

                    // Disable the submit button to prevent multiple clicks
                    submitButton.prop('disabled', true);
                    submitButton.text('Submitting...'); // Optional: change button text

                    $.ajax({
                        url: "{{ route('teamHead.teamHead_leave_request_store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            const addModal = bootstrap.Offcanvas.getInstance(document
                                .getElementById('add-new-record'));
                            addModal.hide();
                            // Reload the page to reflect changes
                            location.reload();
                        },
                        error: function(xhr) {
                            // Re-enable the button and show error
                            submitButton.prop('disabled', false);
                            submitButton.text('Create'); // Reset the button text
                            alert('Error: ' + (xhr.responseJSON.message ||
                                'Something went wrong.'));
                        }
                    });

                    return false; // Prevent the form from submitting normally
                }
            });

            // Form validation for leave edit
            $('.leaveEdit').validate({
                rules: {
                    leave_type: {
                        required: true,
                    },
                    from_date: {
                        required: true,
                    },
                    to_date: {
                        required: true,
                    },
                    leave_reason: {
                        required: true,
                    },
                },
                messages: {
                    leave_type: {
                        required: "Leave type is required",
                    },
                    from_date: {
                        required: "From date is required",
                    },
                    to_date: {
                        required: "To date is required",
                    },
                    leave_reason: {
                        required: "Reason is required",
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('add_leave_type') || element.hasClass(
                            'leave_reason')) {
                        error.insertAfter(
                            element);
                    } else {
                        error.insertAfter(
                            element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    if (!$(element).hasClass('add_leave_type') && !$(element)
                        .hasClass('leave_reason')) {
                        $(element).addClass(errorClass).removeClass(validClass);
                    }
                },
                unhighlight: function(element, errorClass, validClass) {
                    if (!$(element).hasClass('add_leave_type') && !$(element)
                        .hasClass('leave_reason')) {
                        $(element).removeClass(errorClass).addClass(validClass);
                    }
                },
                submitHandler: function(form) {
                    const formData = new FormData(form);
                    const submitButton = $(form).find('button[type="submit"]');

                    // Disable the submit button to prevent multiple clicks
                    submitButton.prop('disabled', true);
                    submitButton.text('Updating...'); // Optional: change button text

                    $.ajax({
                        url: "{{ route('teamHead.teamHead_edit_leave_request') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            const editModal = bootstrap.Offcanvas.getInstance(document
                                .getElementById('edit-new-record'));
                            editModal.hide();
                            // Reload the page to reflect changes
                            location.reload();
                        },
                        error: function(xhr) {
                            // Re-enable the button and show error
                            submitButton.prop('disabled', false);
                            submitButton.text('Update'); // Reset the button text
                            alert('Error: ' + (xhr.responseJSON.message ||
                                'Something went wrong.'));
                        }
                    });

                    return false; // Prevent the form from submitting normally
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Delete button click event
            $('.delete').on('click', function(e) {
                e.preventDefault(); // Prevent default link behavior

                // Get the ID from the clicked button
                var id = $(this).data('id');

                // Set the ID in the hidden input field
                $('#delete-id').val(id);

                // Show the offcanvas modal
                var deleteModal = new bootstrap.Offcanvas(document.getElementById('delete-new-record'));
                deleteModal.show();
            });

            // Confirm delete button click event
            $('#confirm-delete-btn').on('click', function() {
                // Get the ID from the hidden input field
                var id = $('#delete-id').val();

                // Send AJAX request to delete the record
                $.ajax({
                    url: "{{ route('teamHead.teamHead_delete_leave_request') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                        id: id
                    },
                    success: function(response) {
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON.message ||
                            'Unable to delete the record.'));
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to toggle the Delete button visibility based on selected checkboxes
            function toggleDeleteButton() {
                var selectedCount = $('.select_row:checked').length; // Count how many checkboxes are checked
                if (selectedCount > 0) {
                    $('#delete_button').attr('style', 'display: block !important;'); // Show the delete button
                } else {
                    $('#delete_button').attr('style', 'display: none !important;'); // Hide the delete button
                }
            }

            // Select/Deselect all checkboxes when the 'Select All' checkbox is clicked
            $('#select_all').on('click', function() {
                var isChecked = $(this).prop('checked'); // Get the checked status of 'Select All'
                $('.select_row').prop('checked', isChecked); // Set the checked status of all rows
                toggleDeleteButton(); // Update Delete button visibility
            });

            // Update the 'Select All' checkbox based on individual row checkboxes
            $('.select_row').on('click', function() {
                var allChecked = $('.select_row').length === $('.select_row:checked')
                .length; // Check if all checkboxes are selected
                $('#select_all').prop('checked', allChecked); // Update 'Select All' checkbox
                toggleDeleteButton(); // Update Delete button visibility
            });

            // Handle the Delete button click for multiple selected rows
            $('#delete_button').on('click', function() {
                var selectedIds = $('.select_row:checked').map(function() {
                    return $(this).data('id'); // Get the ID of each selected row
                }).get();

                if (selectedIds.length > 0) {
                    // Show confirmation modal for multiple deletions
                    const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById(
                        'delete-new-record'));
                    offcanvasdelete.show();
                    $('#delete-id').val(selectedIds.join(',')); // Join the selected IDs with commas
                }
            });

            // Handle the individual delete button click
            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id'); // Get the ID of the selected holiday
                event.preventDefault();

                // Show confirmation modal for a single deletion
                const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById(
                    'delete-new-record'));
                offcanvasdelete.show();
                $('#delete-id').val(id); // Set the ID of the single holiday to be deleted
            });
        });
    </script>
    <script>
        // jQuery to toggle between Show More and Show Less
        $(document).ready(function() {
            $('.show-more').click(function() {
                var parent = $(this).closest('.details-display');
                parent.find('.details-short').hide(); // Hide the short text
                parent.find('.details-more').hide(); // Hide the "Show More" link
                parent.find('.details-full').show(); // Show the full details
                parent.find('.show-less').show(); // Show the "Show Less" link
            });

            $('.show-less').click(function() {
                var parent = $(this).closest('.details-display');
                parent.find('.details-short').show(); // Show the short text
                parent.find('.details-more').show(); // Show the "Show More" link
                parent.find('.details-full').hide(); // Hide the full details
                parent.find('.show-less').hide(); // Hide the "Show Less" link
            });
        });
    </script>
@endsection
