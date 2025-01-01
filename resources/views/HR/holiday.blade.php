@extends('HR.hr_layout.sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    div.dataTables_wrapper {
        position: relative;
        padding: 1.5%;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color : white !important;
    }

    .light-style table.table-bordered.dataTable th,
    .light-style table.table-bordered.dataTable td {
        border-color: #E6E59C !important;
    }

    table.dataTable.no-footer {
        border-bottom: 0px solid #E6E5E8;
    }
    body.dark-mode table.dataTable.no-footer {
        border-bottom: 0px solid #474360;
    }
    body.dark-mode .list-btn {
        color: #b0acc7 !important;
    }

    .list-btn {
        color: #8b8693;
    }

    label.error {
        display: block;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">Holiday List</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">
                            <button class="btn create-new waves-effect waves-light employee"  style=" background: #7e4ee6;color: #f0f8ff;"
                                tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i
                                        class="ri-add-line"></i> <span class="d-none d-sm-inline-block">Add New
                                        Holiday</span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <!-- The Delete Button (initially hidden) -->
              
                <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                    aria-describedby="DataTables_Table_0_info" style="width: 1395px;">
                    <thead>
                        <tr>
                            <!-- Add a checkbox in the header for "Select All" -->
                            <th>
                                <input type="checkbox" id="select_all">
                            </th>
                            <th>Sr No.</th>
                            <th>Holiday Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($holidays as $item)
                            <tr>
                                <!-- Add checkbox for each row -->
                                <td>
                                    <input type="checkbox" class="select_row" data-id="{{$item->id}}">
                                </td>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{$item->holiday_name}}</td>
                                <td>
                                    @if(\Carbon\Carbon::hasFormat($item->holiday_date, 'Y-m-d'))
                                        {{ \Carbon\Carbon::parse($item->holiday_date)->format('d-m-y') }}
                                    @endif
                                </td>
                                <td>
                                    @if(\Carbon\Carbon::hasFormat($item->end_date, 'Y-m-d'))
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-y') }}
                                    @endif
                                </td>
                                <td>{{$item->details}}</td>
                                <td>
                                    <a class="edit" href="#" data-id='{{$item->id}}'
                                        data-holiday_name='{{$item->holiday_name}}'
                                        data-holiday_date='{{ \Carbon\Carbon::parse($item->holiday_date)->format('d-m-Y') }}'
                                        data-end_date='{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}'
                                        data-details="{{$item->details}}">
                                        <i class="ri-edit-box-line ri-22px list-btn"></i>
                                    </a>
                                    <a href="#" class="delete" data-id='{{$item->id}}'>
                                        <i class="ri-delete-bin-7-line ri-22px list-btn"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                  <button class="dt-button buttons-delete btn btn-danger buttons-html5 btn-delete" tabindex="0" aria-controls="example" type="button" style="display:none !important;" id="delete_button">
                    <i class="ri-delete-bin-7-line ri-22px"></i>
                </button>
            </div>
        </div>
    </div>

    <!--add Holiday  -->
    <div class="offcanvas offcanvas-end" id="enterdepartmentmodal" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel">Add Holiday</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('hr.holiday_store')}}" method="post" id="myForm" enctype="multipart/form-data"
                class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-18px ri-sun-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dt-full-name" name="holiday_name"
                                placeholder="Enter Holiday name" aria-label="Enter Holiday name" required>
                            <label for="basicFullname">Holiday</label>
                        </div>
                    </div>
                    <label id="holiday_name-error" class="error remove-error" for="holiday_name"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-calendar-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dob-picker" name="holiday_date"
                                placeholder="Select Start Date" required readonly>
                            <label for="basicFullname">Start Date</label>
                        </div>
                    </div>
                    <label id="holiday_date-error" class="error remove-error" for="holiday_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-calendar-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dob-picker" placeholder="Select End Date"
                                name="holiday_end_date" required readonly/>
                            <label for="basicFullname">End Date</label>
                        </div>
                    </div>
                    <label id="holiday_end_date-error" class="error remove-error" for="holiday_end_date"></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-sticky-note-add-line"></i></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" class="form-control" name="details" row="15" cols="50"
                                placeholder="Enter Details" aria-label="Enter Date" aria-describedby="basicFullname2"></textarea>
                            <label for="basicFullname">Details</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" style="background: linear-gradient(270deg, #B30000 0%, #FF6666 100%) !important;color: #F0F8FF;"
                        class="btn data-submit me-sm-4 me-1 ">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- edit add Holiday  -->
    <div class="offcanvas offcanvas-end" id="editmodal" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="exampleModalLabel">Edit Holiday</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form action="{{route('hr.holiday_edit')}}" method="post" id="editForm" enctype="multipart/form-data"
                class="add-new-record pt-0 row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="tf-icons ri-sun-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dt-full-name" name="holiday_name" id="holiday_name"
                                placeholder="Enter department name" aria-label="Enter Holiday name" required>
                            <label for="basicFullname">Holiday</label>
                        </div>
                    </div>
                    <label id="holiday_name-error" class="error remove-error" for="holiday_name" ></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-calendar-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dob-picker" name="holiday_date" id="holiday_date"
                                placeholder="Select Start Date" required readonly>
                            <label for="basicFullname">Start Date</label>
                        </div>
                    </div>
                    <label id="holiday_date-error" class="error remove-error" for="holiday_date" style=""></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i
                                class="ri-calendar-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control dob-picker" placeholder="Select End Date"
                                name="holiday_end_date" id="holiday_end_date" required  readonly/>
                            <label for="basicFullname">End Date</label>
                        </div>
                    </div>
                    <label id="holiday_end_date-error" class="error" for="holiday_end_date" style=""></label>
                </div>
                <div class="col-sm-12 fv-plugins-icon-container mt-5">
                    <div class="input-group input-group-merge">
                        <span id="basicFullname2" class="input-group-text"><i class="ri-user-line ri-18px"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" class="form-control dt-full-name" name="details" id="details"
                                placeholder="Enter Details" aria-label="Enter Date" aria-describedby="basicFullname2"></textarea>
                            <label for="basicFullname">Details</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" style="background: linear-gradient(270deg, #B30000 0%, #FF6666 100%) !important;color: #F0F8FF;"
                        class="btn data-submit me-sm-4 me-1 ">Update</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal (Offcanvas) -->
    <div class="offcanvas offcanvas-end" id="deletemodal" aria-modal="true" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="deleteExampleModalLabel">Delete Holiday</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <h5 class="text-center">Are you sure you want to delete the selected holidays?</h5>
            <form action="{{ route('hr.holiday_delete') }}" method="POST" id="delete-form">
                @csrf
                <input type="hidden" name="ids" id="delete-ids">
                <div class="col-sm-12">
                    <button type="submit" class="btn waves-effect waves-light" style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color:white">Delete</button>
                    <button type="reset" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- datable java script --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>


<script type="text/javascript">
    $(document).ready(function () {


$('#myForm').validate({
            rules: {
                holiday_name: {
                    required: true
                },
                holiday_date: {
                    required: true
                },
                holiday_end_date: {
                    required: true
                }
            },
            messages: {
                holiday_name: {
                    required: "Holiday name is required"
                },
                holiday_date: {
                    required: "Start Date is required"
                },
                holiday_end_date: {
                    required: "End Date is required"
                }
            },
            errorPlacement: function (error, element) {
                // Ensure error labels are shown next to the respective inputs
                error.insertAfter(element);
            },
            success: function (label) {
                // Optionally add styles for valid fields
                label.text(''); // Clear error text
            },
           
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

        });
        $(document).on('click', '.employee', function (event) {
            event.preventDefault();
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('enterdepartmentmodal'));
            offcanvasEdit.show();
        });
        $(document).on('click', '.edit', function (event) {
            event.preventDefault();

            // Fetch data attributes
            var id = $(this).data('id');
            var holiday_name = $(this).data('holiday_name');
            var holiday_date = $(this).data('holiday_date');
            var end_date = $(this).data('end_date');
            var details = $(this).data('details');

            // Open offcanvas modal
            const offcanvasEdit = new bootstrap.Offcanvas(document.getElementById('editmodal'));
            offcanvasEdit.show();

            // Populate modal fields
            $('#holiday_name').val(holiday_name);
            $('#holiday_date').val(holiday_date);
            $('#holiday_end_date').val(end_date);
            $('#details').val(details);
            $('#id').val(id);

            // Reset validation states
            $('#editForm').validate().resetForm();
        });

        $('#editForm').validate({
            // Validation rules
            rules: {
                holiday_name: {
                    required: true,
                },
                holiday_date: {
                    required: true,
                },
                holiday_end_date: {
                    required: true,
                },
            },
            // Validation messages
            messages: {
                holiday_name: {
                    required: "Holiday name is required.",
                },
                holiday_date: {
                    required: "Start Date is required.",
                },
                holiday_end_date: {
                    required: "End Date is required.",
                },
            },
             errorPlacement: function (error, element) {
                // Ensure error labels are shown next to the respective inputs
                error.insertAfter(element);
            },
            success: function (label) {
                // Optionally add styles for valid fields
                label.text(''); // Clear error text
            },
          
                    // Submit handler
                submitHandler: function (form) {
                var formData = new FormData(form); // Get form data, including files
                var url = $(form).attr('action'); // Get the form's action URL
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        location.reload(); // Reload the page on success
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        });

        $(document).on('click', '.delete', function (event) {
            var id = $(this).data('id');
            event.preventDefault();
            const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
            console.log(offcanvasdelete, 'offcanvasdelete')
            offcanvasdelete.show();
            $('#delete-id').val(id)

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
        toggleDeleteButton(); // Call to update Delete button visibility
    });

    // Update the 'Select All' checkbox based on individual row checkboxes
    $('.select_row').on('click', function() {
        var allChecked = $('.select_row').length === $('.select_row:checked').length; // Check if all checkboxes are selected
        $('#select_all').prop('checked', allChecked); // Update 'Select All' checkbox
        toggleDeleteButton(); // Call to update Delete button visibility
    });

    // Handle the Delete button click for multiple selected rows
    $('#delete_button').on('click', function() {
        var selectedIds = $('.select_row:checked').map(function() {
            return $(this).data('id'); // Get the ID of each selected row
        }).get();
        
        if (selectedIds.length > 0) {
            // Show confirmation modal for multiple deletions
            const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
            offcanvasdelete.show();
            $('#delete-ids').val(selectedIds.join(',')); // Join the selected IDs with commas for multiple deletions
        }
    });

    // Handle the individual delete button click
    $(document).on('click', '.delete', function (event) {
        var id = $(this).data('id'); // Get the ID of the selected holiday
        event.preventDefault();

        // Show confirmation modal for a single deletion
        const offcanvasdelete = new bootstrap.Offcanvas(document.getElementById('deletemodal'));
        offcanvasdelete.show();
        $('#delete-ids').val(id); // Set the ID of the single holiday to be deleted
    });
    });
</script>
@endsection