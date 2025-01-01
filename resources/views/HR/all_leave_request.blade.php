@extends('HR.hr_layout.sidebar')
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
            border-bottom: 0px solid #E6E5E8;
    }
    body.dark-mode table.dataTable.no-footer {
        border-bottom: 0px solid #474360;
    }


select#edit_leave_type {
    background: #312d4b !important;
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
                            <button class="btn btn-secondary create-new btn-primary waves-effect waves-light employee"
                                tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                <span>
                                    <i class="ri-add-line"></i>
                                    <span class="d-none d-sm-inline-block">Add New Record</span>
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
                            <th>Sr No.</th>
                            <th>Apply Date</th>
                            <th>Leave Type</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Reason</th>
                            <th>Admin Status </th>
                            <th>Admin Rejecte Reason</th>
                            <th>Team Head Status</th>
                            <th>Team Head Rejecte </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-y') }}</td>
                                <td class="leaveType">{{ $item->leaveType->leave_type ?? 'N/A' }}</td>

                                <td class="fromDate">{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-y') }}</td>
                                <td class="toDate">@if($item->to_date != null)
                                    {{ \Carbon\Carbon::parse($item->to_date)->format('d-m-y') }}
                                @endif
                                </td>
                                <td class="leaveReason">{{$item->leave_reason}}</td>
                                <td>
                                    @if($item->status == NULL)
                                        <div></div>
                                    @elseif($item->status == 0)
                                        <div style="color: red">Rejected</div>
                                    @elseif($item->status == 1)
                                        <div style="color: green">Approved</div>
                                    @endif
                                </td>
                                <td>{{$item->rejected_reason}}</td>
                                <td>
                                    @if($item->team_head_status == NULL)
                                        <div></div>
                                    @elseif($item->team_head_status == 0)
                                        <div style="color: red">Rejected</div>
                                    @elseif($item->team_head_status == 1)
                                        <div style="color: green">Approved</div>
                                    @endif
                                </td>
                                <td>{{$item->team_head_rejected_reasons}}</td>
                                <td>
                                    <a class="edit" href="#" data-id='{{$item->id}}' data-leave='{{$item->leave_type}}'
                                        data-from_date='{{$item->from_date}}' data-to_date='{{$item->to_date}}'
                                        data-leave_reason='{{$item->leave_reason}}'>
                                        <i class="ri-edit-box-line" style="font-size:24px;color:#36a50b"></i>
                                    </a>
                                    <a href="#" class="delete" data-id='{{$item->id}}'>
                                        <i class="ri-delete-bin-6-line" style="font-size:24px;color:red"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            <div class="col-sm-12 fv-plugins-icon-container">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                    <div class="form-floating form-floating-outline">
                        <select class="form-control leave_type" name="leave_type" id="add_leave_type">
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
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="date" class="form-control dob-picker" name="from_date" id="add_from_date"
                            placeholder="">
                        <label for="add_from_date">From Date</label>
                    </div>
                </div>
                <label id="add_from_date-error" class="error" for="add_from_date"></label>
            </div>
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="date" class="form-control dob-picker" name="to_date" id="add_to_date"
                            placeholder="">
                        <label for="add_to_date">To Date</label>
                    </div>
                </div>
                <label id="add_to_date-error" class="error" for="add_to_date"></label>
            </div>
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span id="add_leave_reason" class="input-group-text"><i
                            class="ri-sticky-note-add-line"></i></i></span>
                    <div class="form-floating form-floating-outline">
                        <textarea type="text" class="form-control" name="leave_reason" id="add_leave_reason"
                            placeholder="Enter Employee Reason"></textarea>
                        <label for="add_leave_reason">Reason</label>
                    </div>
                </div>
                <label id="add_leave_reason-error" class="error" for="add_leave_reason"></label>
            </div>
            <button type="submit" class="btn mt-3" style="background: #7e4ee6;color: #f0f8ff;">Create</button>
        </form>
    </div>
</div>


<!-- Edit Modal -->
<div class="offcanvas offcanvas-end" id="edit-new-record" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="myModalLabel">Edit Leave Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="editForm" method="POST" enctype="multipart/form-data" class="leaveEdit">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="col-sm-12 fv-plugins-icon-container">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ri-building-line ri-18px"></i></span>
                    <div class="form-floating form-floating-outline">
                        <select class="form-control" name="leave_type" id="edit_leave_type">
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
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="date" class="form-control dob-picker" name="from_date" id="edit_from_date"
                            placeholder="">
                        <label for="basicFullname">From Date</label>
                    </div>
                </div>
                <label id="edit_from_date-error" class="error" for="edit_from_date"></label>
            </div>
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                    <div class="form-floating form-floating-outline">
                        <input type="date" class="form-control dob-picker" name="to_date" id="edit_to_date"
                            placeholder="">
                        <label for="basicFullname">To Date</label>
                    </div>
                </div>
                <label id="edit_to_date-error" class="error" for="edit_to_date"></label>
            </div>
            <div class="col-sm-12 fv-plugins-icon-container mt-3">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="ri-sticky-note-add-line"></i></i></span>
                    <div class="form-floating form-floating-outline">
                        <textarea type="text" class="form-control" name="leave_reason" id="edit_leave_reason"
                            placeholder="Enter Employee Reason"></textarea>
                        <label for="edit_leave_reason">Reason</label>
                    </div>
                </div>
                <label id="edit_leave_reason-error" class="error" for="edit_leave_reason"></label>
            </div>
            <button type="submit" class="btn btn-primary mt-3"
                style="background: #7e4ee6;color: #f0f8ff;">Update</button>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal (Offcanvas) -->
<div class="offcanvas offcanvas-end" id="delete-new-record" aria-labelledby="myModalLabel" aria-modal="true"
    tabindex="-1" role="dialog">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="myModalLabel">Delete Leave Request</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <h5 class="text-center mb-4">Are you sure you want to delete this leave request?</h5>
        <input type="hidden" name="id" id="delete-id"> <!-- Hidden field for the leave request ID -->
        <div class="d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Open Add New Record Offcanvas
        const openAddButton = document.querySelector('.create-new');
        const offcanvasAdd = new bootstrap.Offcanvas(document.getElementById('add-new-record'));

        openAddButton.addEventListener('click', function () {
            offcanvasAdd.show();
        });

        // Open Edit Record Offcanvas
        $(document).on('click', '.edit', function (event) {
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

        $(document).ready(function () {
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
                    frleave_reasonom_date: {
                        required: "Reason is required",
                    },
                },
                submitHandler: function (form) {
                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('teamHead.teamHead_leave_request_store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            const addModal = bootstrap.Offcanvas.getInstance(document.getElementById('add-new-record'));
                            addModal.hide();
                            // Consider updating the table without reloading
                            location.reload();
                        },
                        error: function (xhr) {
                            alert('Error: ' + (xhr.responseJSON.message || 'Something went wrong.'));
                        }
                    });

                    return false; // Prevent the form from submitting normally
                }
            });
        });

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
                frleave_reasonom_date: {
                    required: "Reason is required",
                },
            },
            submitHandler: function (form) {
                const formData = new FormData(form);

                $.ajax({
                    url: "{{ route('teamHead.teamHead_edit_leave_request') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const editModal = bootstrap.Offcanvas.getInstance(document.getElementById('edit-new-record'));
                        editModal.hide();
                        // Consider updating the table without reloading
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error: ' + (xhr.responseJSON.message || 'Something went wrong.'));
                    }
                });

                return false; // Prevent the form from submitting normally
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Delete button click event
        $('.delete').on('click', function (e) {
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
        $('#confirm-delete-btn').on('click', function () {
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
                success: function (response) {
                    location.reload(); // Reload the page to reflect changes
                },
                error: function (xhr) {
                    alert('Error: ' + (xhr.responseJSON.message || 'Unable to delete the record.'));
                }
            });
        });
    });
</script>

@endsection