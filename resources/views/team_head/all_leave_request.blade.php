@extends('team_head.team_head_layout.sidebar')
@section('content')
    <style>
        div.dataTables_wrapper {
            position: relative;
            padding: 1%;
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

        .card-header .input-group {
            margin-bottom: 0;
        }

        .card-header .btn {
            min-width: 100px;
        }

        .btn-secondary {
            color: #fff;
            background-color: #8a58f7;
            border-color: #8a58f7;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
        }

        a.chosen-single {
            height: 47px !important;
            padding: 11px !important;
            background: #ffffff !important;

        }

        body.dark-mode a.chosen-single {
            background: #312d4b !important;
            color: #cbc8e0 !important;
            border-color: #595572;
        }

        body.dark-mode .chosen-drop {
            background: #312d4b !important;
        }

        body.dark-mode ul.chosen-results {
            color: #c2bed8 !important;
        }

        b {
            margin-top: 12px;
        }

        /* Flexbox layout for the form */
        .filter-container {
            display: flex;
            flex-wrap: wrap;
            /* Allow wrapping of elements on smaller screens */
            gap: 15px;
            /* Space between items */
            justify-content: space-between;
        }

        /* Default column widths */
        .col-md-3 {
            flex: 1 1 20%;
            /* 20% width for the employee name dropdown */
        }

        .col-md-2 {
            flex: 1 1 18%;
            /* 18% width for other inputs */
        }

        .input-group,
        .form-floating,
        .form-floating-outline {
            width: 100%;
            /* Ensure form elements take up full width of the column */
        }

        /* Style for submit and refresh buttons */
        .submit-btn,
        .refresh-btn {
            background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;
            color: #f0f8ff;
            border-radius: .375rem !important;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
        }

        .refresh-btn i {
            font-size: 18px;
            /* Icon size */
        }

        /* Responsive for small screens (less than 768px) */
        @media (max-width: 768px) {
            .filter-container {
                flex-direction: column;
                /* Stack the elements vertically on small screens */
                align-items: flex-start;
                /* Align the items to the left */
            }

            .col-md-3,
            .col-md-2 {
                flex: 1 1 100%;
                /* Take full width on smaller screens */
                margin-bottom: 10px;
                /* Add spacing between stacked elements */
            }

            /* Adjust the button size for small screens */
            .submit-btn,
            .refresh-btn {
                width: 100%;
                /* Make the buttons full-width on small screens */
                margin-top: 10px;
            }

            /* For better input sizing on mobile */
            .form-floating,
            .form-floating-outline {
                width: 100%;
            }
        }

        table#example th.sorting {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h6 class="card-title mb-0">Filters</h6>
                <div class="d-flex align-items-center row pt-4 pb-2 gap-3 gx-5">
                    <div class="col-md-3 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname4" class="input-group-text"><i class="ri-search-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select name="search_name" id="search_name" class="form-control multipleChosen"
                                    data-placeholder="Select Employee Name">
                                    <option></option>
                                    @foreach ($getEmployee as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ request('search_name') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->emo_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="search_name">Search by Name</label>
                            </div>
                        </div>
                    </div>
                    <!-- From Date -->
                    <div class="col-md-2 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname1" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="from_date" id="edit_from_date"
                                    value="{{ request('from_date') }}" placeholder="">
                                <label for="edit_from_date">From Date</label>
                            </div>
                        </div>
                    </div>
                    <!-- To Date -->
                    <div class="col-md-2 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname2" class="input-group-text"><i class="ri-calendar-2-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" readonly class="form-control dob-picker" name="to_date" id="edit_to_date"
                                    value="{{ request('to_date') }}" placeholder="">
                                <label for="edit_to_date">To Date</label>
                            </div>
                        </div>
                    </div>
                    <!-- Status Dropdown -->
                    <div class="col-md-2 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basicFullname3" class="input-group-text"><i class="ri-checkbox-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <select id="FilterTransaction" class="form-select text-capitalize">
                                    <option value="">Select Status</option>
                                    <option value="Approved" class="text-capitalize"
                                        {{ request('status') == 'Approved' ? 'selected' : '' }}>
                                        Approved
                                    </option>
                                    <option value="Rejected" class="text-capitalize"
                                        {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                        Rejected
                                    </option>
                                </select>
                                <label for="FilterTransaction">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 fv-plugins-icon-container">
                        <div class="input-group input-group-merge gap-3">
                            <button type="button" class="btn "
                                style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;border-radius: .375rem !important;border:none"
                                id="submitFilters">Submit</button>
                            <button type="button" class="btn "
                                style=" background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;color: #f0f8ff;border-radius: .375rem !important;bo"
                                id="refreshFilters"><i class="ri-refresh-line ri-22px"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="row mx-1">
                        <table class="datatables-basic table table-bordered dataTable no-footer dtr-column" id="example"
                            aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Employee Name</th>
                                    <th>Apply Date</th>
                                    <th>Leave Type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Admin Status</th>
                                    <th>Admin Reject Reason</th>
                                    <th>Team Head Status</th>
                                    <th>Team Head Reject Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td style="overflow-x: auto;white-space: nowrap;">{{ $item->admin->emo_name ?? 'N/A' }}</td>
                                        <td style="overflow-x: auto;white-space: nowrap;">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td style="overflow-x: auto;white-space: nowrap;">{{ $item->leaveType->leave_type ?? 'N/A' }}</td>
                                        <td style="overflow-x: auto;white-space: nowrap;">{{ \Carbon\Carbon::parse($item->from_date)->format('d-m-Y') }}</td>
                                        <td style="overflow-x: auto;white-space: nowrap;">
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
                                        {{-- <td>{{ $item->rejected_reason }}</td> --}}
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
                                            @if ($item->team_head_status == null)
                                                <div></div>
                                            @elseif($item->team_head_status == 0)
                                                <div style="color: red">Rejected</div>
                                            @elseif($item->team_head_status == 1)
                                                <div style="color: green">Approved</div>
                                            @endif
                                        </td>
                                        {{-- <td>{{ $item->team_head_rejected_reasons }}</td> --}}
                                        <td>
                                            <span class="details-display">
                                                <!-- Initially show the first 20 characters of details -->
                                                <span class="details-short">{{ \Str::limit($item->team_head_rejected_reasons, 20) }}</span>
    
                                                <!-- Show "Show More" link if details are longer than 20 characters -->
                                                @if (strlen($item->team_head_rejected_reasons) > 20)
                                                    <span class="details-more">
                                                        <a href="javascript:void(0)" class="show-more">Show More</a>
                                                    </span>
                                                @endif
    
                                                <!-- Full details that will be shown when "Show More" is clicked -->
                                                <span class="details-full"
                                                    style="display: none;">{{ $item->team_head_rejected_reasons }}</span>
    
                                                <!-- Show Less link -->
                                                <span class="show-less" style="display: none;">
                                                    <a href="javascript:void(0)" class="show-less">Show Less</a>
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <a class="edit list-btn" href="#" data-id='{{ $item->id }}'
                                                data-status='{{ $item->team_head_status }}'
                                                data-rejected_reason='{{ $item->team_head_rejected_reasons }}'>
                                                <i class="ri-check-line ri-22px list-btn" style="font-size:24px"></i>
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
    </div>

    <!-- Add Modal -->
    <div class="offcanvas offcanvas-end" id="add-new-record" aria-modal="true" tabindex="-1" aria-labelledby="myModalLabel"
        role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="myModalLabel">Leave Request Approved/Rejected</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('teamHead.teamHead_user_request_leave_approved') }}" method="post" id="password"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id">

                <!-- Status Radio Buttons -->
                <div>
                    <input type="radio" name="status" value="1" id="leave_approved" required />
                    <label for="leave_approved">Approved</label>
                    <input type="radio" name="status" value="0" id="leave_rejected" style="margin-left: 15px"
                        required />
                    <label for="leave_rejected">Rejected</label>
                </div>
                <br>

                <!-- Rejected Reason (Initially Hidden) -->
                <div id="errorexpanded" class="mb-3 attempt_reason" style="display: none;">
                    <label>Reject Reason <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="rejected_reason" id="rejected_reason" required />
                </div>

                <div class="mt-3">
                    <button type="submit" class="text-white p-2 border-0 rounded px-3 fw-bold send_inquiry_btn" id="submitButton"
                        style="background: linear-gradient(270deg, #b30000 0%, #ff6666 100%) !important;">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="offcanvas offcanvas-end" id="delete-new-record" aria-labelledby="myModalLabel" aria-modal="true"
        tabindex="-1" role="dialog">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="myModalLabel">Delete Leave Request</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <h5 class="text-center mb-4">Are you sure you want to delete this leave request?</h5>
            <input type="hidden" name="id" id="delete-id">
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
    <script>
        document.getElementById('password').addEventListener('submit', function (event) {
            const submitButton = document.getElementById('submitButton');
            submitButton.innerHTML = 'Submitting...';
            submitButton.disabled = true;
        });

        // Show/Hide Reject Reason based on selection
        document.getElementById('leave_rejected').addEventListener('change', function () {
            document.getElementById('errorexpanded').style.display = 'block';
        });

        document.getElementById('leave_approved').addEventListener('change', function () {
            document.getElementById('errorexpanded').style.display = 'none';
        });
    </script>
    <script>
        $(document).ready(function() {
            // Listen for the click on the Edit button
            $(document).on('click', '.edit', function(event) {
                event.preventDefault();

                // Get data attributes from the clicked button
                var id = $(this).data('id');
                var status = $(this).data('status');
                var rejected_reason = $(this).data('rejected_reason');

                // Open the modal
                // $('#add-new-record').offcanvas('show');
                const offcanvasDelete = new bootstrap.Offcanvas(document.getElementById('add-new-record'));
                offcanvasDelete.show();

                // Set the form inputs with the fetched data
                $('#id').val(id);
                $('#rejected_reason').val(rejected_reason);

                // Set the radio button based on the status
                if (status == "1") {
                    $("#leave_approved").prop("checked", true);
                } else if (status == "0") {
                    $("#leave_rejected").prop("checked", true);
                }

                // Show/hide the reject reason input based on status
                if (status == "0") {
                    $("#errorexpanded").show();
                } else {
                    $("#errorexpanded").hide();
                }
            });

            

            // Change handler for the status radio buttons
            $('input[type="radio"][name="status"]').on('change', function() {
                if (this.value == "0") {
                    $("#errorexpanded").show();
                    $('#rejected_reason').prop('required', true);
                } else {
                    $("#errorexpanded").hide();
                    $('#rejected_reason').prop('required', false);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Apply Filters
            $('#submitFilters').click(function() {
                var fromDate = $('#edit_from_date').val();
                var toDate = $('#edit_to_date').val();
                var status = $('#FilterTransaction').val();
                var searchName = $('#search_name').val();

                var url = "{{ route('teamHead.teamHead_empolyee_leave_list') }}?from_date=" + fromDate +
                    "&to_date=" + toDate +
                    "&status=" + status +
                    "&search_name=" + searchName;

                console.log(url); // Debugging URL
                window.location.href = url; // Redirect with filters
            });

            // Reset Filters
            $('#refreshFilters').click(function() {
                $('#edit_from_date').val('');
                $('#edit_to_date').val('');
                $('#FilterTransaction').val('');
                $('#search_name').val('');

                window.location.href =
                    "{{ route('teamHead.teamHead_empolyee_leave_list') }}"; // Redirect without filters
            });
        });
        $(document).ready(function() {
            //Chosen
            $(".multipleChosen").chosen({});
        })
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
